<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * API Health & Service Status check.
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'environment' => app()->environment(),
            'service' => config('app.name'),
            'api_version' => 'v1',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * List active services.
     */
    public function services(): JsonResponse
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => ServiceResource::collection($services),
        ]);
    }

    /**
     * List published showcase projects / portfolio.
     */
    public function projects(Request $request): JsonResponse
    {
        $query = Project::where('status', 'active')->latest();

        if ($request->boolean('featured')) {
            $query->where('featured', true);
        }

        if ($request->has('category')) {
            $query->where('category', (string) $request->input('category'));
        }

        $perPage = min(max((int) $request->query('per_page', 12), 1), 30);
        $projects = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => ProjectResource::collection($projects),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'total' => $projects->total(),
            ],
        ]);
    }
}
