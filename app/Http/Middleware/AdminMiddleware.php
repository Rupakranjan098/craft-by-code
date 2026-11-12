<?php

namespace App\Http\Middleware;

use App\Security\RolePermissions;
use App\Security\SecurityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please sign in to access the admin portal.');
        }

        $user = Auth::user();

        if (! $user->is_active) {
            SecurityLogger::log('inactive_account_blocked', 'Inactive account attempted admin access', 'high', $user, $request);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Contact a system administrator.');
        }

        if ($user->isLockedOut()) {
            SecurityLogger::log('login_locked_attempt', 'Locked account attempted admin access', 'warning', $user, $request);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Your account is temporarily locked due to repeated failed attempts.');
        }

        if (! RolePermissions::isBackofficeRole($user->role)) {
            SecurityLogger::log('unauthorized_access', 'Non-privileged user attempted admin portal access', 'high', $user, $request, [
                'role' => $user->role,
            ]);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Unauthorized access: Backoffice privileges required.');
        }

        // Enforce 2FA verification if enrolled on this account
        if ($user->hasTwoFactorEnabled() && $request->session()->get('2fa_verified') !== true) {
            SecurityLogger::log('two_factor_bypass_blocked', 'Admin session lacked completed 2FA challenge', 'high', $user, $request);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Multi-factor authentication verification is required.');
        }

        // Bind session to User-Agent digest to mitigate session hijacking
        $storedUaHash = $request->session()->get('auth_user_agent_hash');
        $currentUaHash = hash('sha256', (string) $request->userAgent());
        if (is_string($storedUaHash) && ! hash_equals($storedUaHash, $currentUaHash)) {
            SecurityLogger::log('session_hijack_suspected', 'Session invalidated due to User-Agent fingerprint mismatch', 'critical', $user, $request);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Your session security fingerprint changed. Please sign in again.');
        }

        // Enforce idle timeout
        $idleTimeoutSeconds = ((int) config('session.lifetime', 60)) * 60;
        $lastActivity = $request->session()->get('auth_last_activity');
        if (is_int($lastActivity) && (now()->timestamp - $lastActivity) > $idleTimeoutSeconds) {
            SecurityLogger::log('session_idle_expired', 'Admin session expired due to inactivity', 'info', $user, $request);
            $this->terminateSession($request);

            return redirect()->route('admin.login')->with('error', 'Your session timed out due to inactivity.');
        }

        $request->session()->put('auth_last_activity', now()->timestamp);

        return $next($request);
    }

    private function terminateSession(Request $request): void
    {
        Auth::logout();
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
