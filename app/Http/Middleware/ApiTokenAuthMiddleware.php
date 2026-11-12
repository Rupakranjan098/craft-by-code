<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
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

            return response()->json(['message' => 'Unauthorized: Bearer token required.'], 401);
        }

        $hash = hash('sha256', $plainToken);
        $tokenRecord = ApiToken::with('user')->where('token_hash', $hash)->first();

        if (! $tokenRecord || ! $tokenRecord->isValid() || ! $tokenRecord->user || ! $tokenRecord->user->is_active) {
            SecurityLogger::log('api_auth_failed', 'API request presented invalid, expired, or revoked Bearer token', 'warning', $tokenRecord?->user, $request);

            return response()->json(['message' => 'Unauthorized: Invalid or expired API token.'], 401);
        }

        if ($requiredAbility && ! $tokenRecord->allows($requiredAbility)) {
            SecurityLogger::log('permission_denied', 'API token lacked required scope', 'warning', $tokenRecord->user, $request, [
                'required_ability' => $requiredAbility,
                'token_id' => $tokenRecord->id,
            ]);

            return response()->json(['message' => 'Forbidden: Token lacks required ability scope.'], 403);
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

