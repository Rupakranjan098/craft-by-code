<?php

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', [ApiController::class, 'health'])
        ->middleware('throttle:api')
        ->name('api.v1.health');

    Route::get('/services', [ApiController::class, 'services'])
        ->middleware(['api.token:services.read', 'throttle:api'])
        ->name('api.v1.services');

    Route::get('/inquiries', [ApiController::class, 'inquiries'])
        ->middleware(['api.token:inquiries.read', 'throttle:api'])
        ->name('api.v1.inquiries');
});

