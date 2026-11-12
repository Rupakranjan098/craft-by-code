<?php

namespace App\Http\Middleware;

use App\Security\SecurityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();
        if (! $user) {
            abort(403, 'Authentication required.');
        }

        $required = array_filter(array_map('trim', explode('|', $permissions)));
        foreach ($required as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        SecurityLogger::log('permission_denied', 'User denied access to protected capability', 'warning', $user, $request, [
            'required_permissions' => $required,
            'role' => $user->role,
        ]);

        abort(403, 'Forbidden: You do not have permission to perform this action.');
    }
}

