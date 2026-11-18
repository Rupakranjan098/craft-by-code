<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiCreateAgreementRequest;
use App\Http\Requests\Api\ApiUpdateAgreementRequest;
use App\Http\Resources\Api\AgreementResource;
use App\Models\Agreement;
use App\Models\AgreementAuditLog;
use App\Security\RolePermissions;
use App\Security\SecurityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiAgreementController extends Controller
{
    /**
     * List accessible agreements.
     * Non-admins only see agreements they own; admins and managers see all.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $isManager = $user->role === 'admin' || $user->role === 'super_admin' || RolePermissions::userHasPermission($user, 'agreements.manage');

        $query = Agreement::with('template')->latest();

        // Enforce Object Ownership filtering: non-managers only see agreements they created
        if (! $isManager) {
            $query->where('created_by', $user->id);
        }

        if ($request->has('status')) {
            $query->where('status', (string) $request->input('status'));
        }

        if ($request->has('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('agreement_number', 'like', $term)
                  ->orWhere('title', 'like', $term)
                  ->orWhere('client_name', 'like', $term)
                  ->orWhere('client_company', 'like', $term);
            });
        }

        $perPage = min(max((int) $request->query('per_page', 15), 1), 50);
        $agreements = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => AgreementResource::collection($agreements),
            'meta' => [
                'current_page' => $agreements->currentPage(),
                'last_page' => $agreements->lastPage(),
                'per_page' => $agreements->perPage(),
                'total' => $agreements->total(),
            ],
        ]);
    }

    /**
     * Retrieve agreement details with strict Object Ownership verification (BOLA / IDOR protection).
     */
    public function show(Request $request, Agreement $agreement): JsonResponse
    {
        $user = $request->user();

        if (Gate::forUser($user)->denies('view', $agreement)) {
            SecurityLogger::log('api_bola_blocked', 'BOLA check failed: User attempted to access unauthorized agreement ID', 'high', $user, $request, [
                'agreement_id' => $agreement->id,
                'agreement_owner' => $agreement->created_by,
            ]);

            return response()->json([
                'status' => 'error',
                'code' => 'FORBIDDEN',
                'message' => 'You do not have ownership or authorization to view this agreement.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => new AgreementResource($agreement),
        ]);
    }

    /**
     * Create a new draft agreement.
     */
    public function store(ApiCreateAgreementRequest $request): JsonResponse
    {
        $user = $request->user();

        if (Gate::forUser($user)->denies('create', Agreement::class)) {
            SecurityLogger::log('permission_denied', 'User lacked agreements.manage permission to create agreement', 'warning', $user, $request);

            return response()->json([
                'status' => 'error',
                'code' => 'FORBIDDEN',
                'message' => 'You lack permission to generate new agreements.',
            ], 403);
        }

        $validated = $request->validated();
        $agreement = new Agreement($validated);
        $agreement->agreement_number = Agreement::generateNextNumber();
        $agreement->status = 'draft';
        $agreement->created_by = $user->id;
        $agreement->save();

        AgreementAuditLog::log(
            $agreement,
            'created',
            "Agreement {$agreement->agreement_number} generated via secure API by {$user->name}.",
            ['source' => 'api_v1']
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Agreement created successfully in draft status.',
            'data' => new AgreementResource($agreement),
        ], 201);
    }

    /**
     * Update an agreement with strict Object Ownership check (BOLA protection).
     */
    public function update(ApiUpdateAgreementRequest $request, Agreement $agreement): JsonResponse
    {
        $user = $request->user();

        if (Gate::forUser($user)->denies('update', $agreement)) {
            SecurityLogger::log('api_bola_blocked', 'BOLA check failed: User attempted to mutate unauthorized agreement ID', 'critical', $user, $request, [
                'agreement_id' => $agreement->id,
                'agreement_owner' => $agreement->created_by,
            ]);

            return response()->json([
                'status' => 'error',
                'code' => 'FORBIDDEN',
                'message' => 'You do not have ownership or authorization to modify this agreement.',
            ], 403);
        }

        $agreement->update($request->validated());
        $agreement->updated_by = $user->id;
        $agreement->save();

        AgreementAuditLog::log(
            $agreement,
            'updated',
            "Agreement {$agreement->agreement_number} updated via secure API by {$user->name}.",
            ['source' => 'api_v1']
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Agreement updated successfully.',
            'data' => new AgreementResource($agreement),
        ]);
    }

    /**
     * Delete a draft agreement with strict ownership verification.
     */
    public function destroy(Request $request, Agreement $agreement): JsonResponse
    {
        $user = $request->user();

        if (Gate::forUser($user)->denies('delete', $agreement)) {
            SecurityLogger::log('api_bola_blocked', 'BOLA check failed: User attempted to delete unauthorized agreement ID', 'critical', $user, $request, [
                'agreement_id' => $agreement->id,
            ]);

            return response()->json([
                'status' => 'error',
                'code' => 'FORBIDDEN',
                'message' => 'You do not have authorization to delete this agreement, or it is not in draft status.',
            ], 403);
        }

        $num = $agreement->agreement_number;
        $agreement->delete();

        SecurityLogger::log('agreement_deleted', "Agreement {$num} deleted via secure API by {$user->name}", 'warning', $user, $request);

        return response()->json([
            'status' => 'success',
            'message' => "Agreement {$num} deleted successfully.",
        ]);
    }
}
