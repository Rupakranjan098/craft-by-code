<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Security\RolePermissions;
use App\Security\SecurityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuthMiddleware
{
    public function handle(Request $request, Closure $next, ?string $requiredAbility = null): Response
    {
        $plainToken = $request->bearerToken();
        if (! is_string($plainToken) || $plainToken === '') {
            SecurityLogger::log('api_auth_failed', 'API request missing Bearer token', 'warning', null, $request);

            return response()->json([
                'status' => 'error',
                'code' => 'UNAUTHORIZED',
                'message' => 'Unauthorized: Bearer token is required.',
            ], 401);
        }

        $hash = hash('sha256', $plainToken);
        $tokenRecord = ApiToken::with('user')->where('token_hash', $hash)->first();

        if (! $tokenRecord || ! $tokenRecord->isValid() || ! $tokenRecord->user || ! $tokenRecord->user->is_active) {
            SecurityLogger::log('api_auth_failed', 'API request presented invalid, expired, or revoked Bearer token', 'warning', $tokenRecord?->user, $request);

            return response()->json([
                'status' => 'error',
                'code' => 'INVALID_TOKEN',
                'message' => 'Unauthorized: Invalid, expired, or revoked API token.',
            ], 401);
        }

        // 1. Enforce Token Scope Ability Check
        if ($requiredAbility) {
            $hasAbility = $tokenRecord->allows($requiredAbility);

            // Check synonym (e.g. inquiries.read <-> inquiries.view)
            if (! $hasAbility) {
                $synonym = str_ends_with($requiredAbility, '.read')
                    ? str_replace('.read', '.view', $requiredAbility)
                    : (str_ends_with($requiredAbility, '.view') ? str_replace('.view', '.read', $requiredAbility) : null);

                if ($synonym && $tokenRecord->allows($synonym)) {
                    $hasAbility = true;
                }
            }

            if (! $hasAbility) {
                SecurityLogger::log('permission_denied', "API token lacked required scope '{$requiredAbility}'", 'warning', $tokenRecord->user, $request, [
                    'required_ability' => $requiredAbility,
                    'token_id' => $tokenRecord->id,
                ]);

                return response()->json([
                    'status' => 'error',
                    'code' => 'FORBIDDEN',
                    'message' => "Forbidden: Token lacks required scope '{$requiredAbility}'.",
                ], 403);
            }
        }

        // 2. Enforce User Role RBAC Permission Check (BFLA prevention)
        if ($requiredAbility && ! in_array($requiredAbility, ['services.read', 'projects.read'], true)) {
            $rbacPerm = str_replace('.read', '.view', $requiredAbility);
            $hasUserPerm = RolePermissions::userHasPermission($tokenRecord->user, $rbacPerm) || RolePermissions::userHasPermission($tokenRecord->user, $requiredAbility);

            if (! $hasUserPerm) {
                SecurityLogger::log('permission_denied', "User role lacked required permission '{$requiredAbility}'", 'warning', $tokenRecord->user, $request, [
                    'required_permission' => $requiredAbility,
                    'user_role' => $tokenRecord->user->role,
                ]);

                return response()->json([
                    'status' => 'error',
                    'code' => 'FORBIDDEN',
                    'message' => "Forbidden: Your account role does not have permission '{$requiredAbility}'.",
                ], 403);
            }
        }

        $tokenRecord->forceFill([
            'last_used_at' => now(),
            'last_used_ip' => $request->ip(),
        ])->save();

        Auth::setUser($tokenRecord->user);
        $request->setUserResolver(fn () => $tokenRecord->user);
        $request->attributes->set('api_token', $tokenRecord);

        return $next($request);
    }
}
