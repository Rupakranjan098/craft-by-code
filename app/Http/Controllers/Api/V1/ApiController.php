<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'service' => config('app.name'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function services(): JsonResponse
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get([
                'id',
                'title',
                'slug',
                'badge',
                'short_description',
                'features',
                'order',
            ]);

        return response()->json([
            'data' => $services,
        ]);
    }

    public function inquiries(Request $request): JsonResponse
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 50);

        $inquiries = ContactInquiry::latest()
            ->paginate($perPage, [
                'id',
                'name',
                'company',
                'service_interested',
                'status',
                'created_at',
            ]);

        return response()->json($inquiries);
    }
}
