<?php

use App\Http\Controllers\Api\V1\ApiAgreementController;
use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\ApiInquiryController;
use App\Http\Controllers\Api\V1\ApiTokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| High-Security Versioned API Routes (v1)
|--------------------------------------------------------------------------
|
| Features:
| - Enforced HTTPS & HSTS via ApiSecurityHeadersMiddleware
| - Malicious bot & automated exploit scanner defense via BlockMaliciousBotsMiddleware
| - Deep payload sanitization & null-byte stripping via SanitizeApiInputMiddleware
| - Tiered rate limiting (api-auth, api-write, api-read)
| - Broken Object Level Authorization (BOLA / IDOR) checks on all resources
| - Broken Function Level Authorization (BFLA) RBAC checks
| - Strict attribute whitelisting with JsonResource transformers
| - Shadow API endpoints retired with clean 404 fallback
|
*/

Route::prefix('v1')
    ->middleware(['api.security', 'api.botblock', 'api.sanitize'])
    ->group(function () {

        // 1. Health & Status Telemetry
        Route::get('/health', [ApiController::class, 'health'])
            ->middleware('throttle:api-read')
            ->name('api.v1.health');

        // 2. Authentication & Token Lifecycle
        Route::prefix('auth')->group(function () {
            // Dynamic Login with brute-force rate limit
            Route::post('/login', [ApiAuthController::class, 'login'])
                ->middleware('throttle:api-auth')
                ->name('api.v1.auth.login');

            // Authenticated Token Actions
            Route::middleware('api.token')->group(function () {
                Route::get('/me', [ApiAuthController::class, 'me'])
                    ->middleware('throttle:api-read')
                    ->name('api.v1.auth.me');

                Route::post('/refresh', [ApiAuthController::class, 'refresh'])
                    ->middleware('throttle:api-write')
                    ->name('api.v1.auth.refresh');

                Route::post('/logout', [ApiAuthController::class, 'logout'])
                    ->name('api.v1.auth.logout');

                Route::post('/logout-all', [ApiAuthController::class, 'logoutAll'])
                    ->name('api.v1.auth.logout-all');
            });
        });

        // 3. Showcase Content (Scoped Reader Tokens)
        Route::get('/services', [ApiController::class, 'services'])
            ->middleware(['api.token:services.read', 'throttle:api-read'])
            ->name('api.v1.services');

        Route::get('/projects', [ApiController::class, 'projects'])
            ->middleware(['api.token:projects.read', 'throttle:api-read'])
            ->name('api.v1.projects');

        // 4. Inquiries Management
        Route::prefix('inquiries')->middleware('api.token:inquiries.view')->group(function () {
            Route::get('/', [ApiInquiryController::class, 'index'])
                ->middleware('throttle:api-read')
                ->name('api.v1.inquiries.index');

            Route::get('/{inquiry}', [ApiInquiryController::class, 'show'])
                ->whereNumber('inquiry')
                ->middleware('throttle:api-read')
                ->name('api.v1.inquiries.show');

            Route::put('/{inquiry}/status', [ApiInquiryController::class, 'updateStatus'])
                ->whereNumber('inquiry')
                ->middleware(['api.token:inquiries.manage', 'throttle:api-write'])
                ->name('api.v1.inquiries.status');
        });

        // 5. Digital Agreements & Contracts (BOLA & RBAC Enforced)
        Route::prefix('agreements')->middleware('api.token:agreements.view')->group(function () {
            Route::get('/', [ApiAgreementController::class, 'index'])
                ->middleware('throttle:api-read')
                ->name('api.v1.agreements.index');

            Route::get('/{agreement}', [ApiAgreementController::class, 'show'])
                ->whereNumber('agreement')
                ->middleware('throttle:api-read')
                ->name('api.v1.agreements.show');

            Route::post('/', [ApiAgreementController::class, 'store'])
                ->middleware(['api.token:agreements.manage', 'throttle:api-write'])
                ->name('api.v1.agreements.store');

            Route::put('/{agreement}', [ApiAgreementController::class, 'update'])
                ->whereNumber('agreement')
                ->middleware(['api.token:agreements.manage', 'throttle:api-write'])
                ->name('api.v1.agreements.update');

            Route::delete('/{agreement}', [ApiAgreementController::class, 'destroy'])
                ->whereNumber('agreement')
                ->middleware(['api.token:agreements.manage', 'throttle:api-write'])
                ->name('api.v1.agreements.destroy');
        });

        // 6. API Token Management (Self & Admin)
        Route::prefix('tokens')->middleware('api.token:api.tokens.manage')->group(function () {
            Route::get('/', [ApiTokenController::class, 'index'])
                ->middleware('throttle:api-read')
                ->name('api.v1.tokens.index');

            Route::post('/', [ApiTokenController::class, 'store'])
                ->middleware('throttle:api-write')
                ->name('api.v1.tokens.store');

            Route::delete('/{token}', [ApiTokenController::class, 'destroy'])
                ->whereNumber('token')
                ->middleware('throttle:api-write')
                ->name('api.v1.tokens.destroy');
        });
    });

// 7. Shadow API Retirement & Strict Fallback Handler
Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'code' => 'ENDPOINT_NOT_FOUND',
        'message' => 'The requested API endpoint does not exist or has been retired for security compliance.',
    ], 404);
});
