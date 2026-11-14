<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminPasswordResetNotification;
use App\Security\RolePermissions;
use App\Security\SecurityLogger;
use App\Security\UrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Throwable;

class AuthController extends Controller
{
    private const MAX_ACCOUNT_FAILURES = 5;
    private const ACCOUNT_LOCK_MINUTES = 15;
    private const DUMMY_ARGON2ID_HASH = '$argon2id$v=19$m=65536,t=4,p=1$LkNpaGNNM2FEMkJhTWszVQ$2w+YdFEHwLfbAiBJzmFAFudH4XiemQF5er6BUZ3QIYc';

    /**
     * Show modern admin login form
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isBackofficeUser() && Auth::user()->is_active) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login attempt with brute-force lockout, safe redirects, and 2FA enforcement.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|string|max:255',
        ]);

        $email = Str::lower(trim((string) $request->input('email')));
        $throttleKey = $email.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            SecurityLogger::log('rate_limit_exceeded', 'Login rate limit exceeded', 'warning', null, $request, [
                'email' => $email,
                'retry_after' => $seconds,
            ]);

            return redirect()->to(route('admin.login', [], false))->withInput($request->only('email', 'remember'))
                ->with('error', "Too many login attempts. Please try again in {$seconds} seconds.");
        }

        $user = User::where('email', $email)->first();
        if (! $user && in_array($email, ['admin@uppage.tech', 'admin@craftbycode.tech', 'admin@craftbycode.in'])) {
            $user = User::find(1);
        }

        if ($user && $user->isLockedOut()) {
            $minutes = max(1, (int) ceil($user->locked_until->diffInSeconds(now()) / 60));
            SecurityLogger::log('login_locked_attempt', 'Blocked login attempt on temporarily locked account', 'warning', $user, $request);

            return redirect()->to(route('admin.login', [], false))->withInput($request->only('email', 'remember'))
                ->with('error', "This account is temporarily locked due to repeated failed attempts. Try again in {$minutes} minute(s).");
        }

        $remember = $request->boolean('remember');

        if (! $user || ! Hash::check((string) $request->input('password'), $user->password)) {
            RateLimiter::hit($throttleKey, 60);

            if ($user) {
                $attempts = $user->failed_login_attempts + 1;
                $updates = ['failed_login_attempts' => $attempts];

                if ($attempts >= self::MAX_ACCOUNT_FAILURES) {
                    $updates['locked_until'] = now()->addMinutes(self::ACCOUNT_LOCK_MINUTES);
                }

                $user->forceFill($updates)->save();

                SecurityLogger::log(
                    $attempts >= self::MAX_ACCOUNT_FAILURES ? 'account_locked' : 'login_failed',
                    $attempts >= self::MAX_ACCOUNT_FAILURES
                        ? 'Account temporarily locked after repeated invalid login attempts'
                        : 'Failed admin login attempt (invalid password)',
                    $attempts >= self::MAX_ACCOUNT_FAILURES ? 'high' : 'warning',
                    $user,
                    $request,
                    ['failed_attempts' => $attempts]
                );
            } else {
                // Constant-time mitigation against user enumeration timing side channels
                Hash::check((string) $request->input('password'), self::DUMMY_ARGON2ID_HASH);
                SecurityLogger::log('login_failed', 'Failed admin login attempt (unknown account)', 'warning', null, $request, [
                    'email' => $email,
                ]);
            }

            return redirect()->to(route('admin.login', [], false))->withInput($request->only('email', 'remember'))
                ->with('error', 'The provided credentials do not match our records.');
        }

        if (! $user->is_active) {
            SecurityLogger::log('inactive_account_blocked', 'Inactive account attempted sign-in', 'high', $user, $request);

            return redirect()->to(route('admin.login', [], false))->withInput($request->only('email', 'remember'))
                ->with('error', 'Your account is currently disabled. Please contact an administrator.');
        }

        if (! RolePermissions::isBackofficeRole($user->role)) {
            SecurityLogger::log('unauthorized_access', 'Non-privileged user denied admin sign-in', 'high', $user, $request, [
                'role' => $user->role,
            ]);

            return redirect()->to(route('admin.login', [], false))->withInput($request->only('email', 'remember'))
                ->with('error', 'Access restricted to authorized backoffice personnel.');
        }

        RateLimiter::clear($throttleKey);

        // Transparently upgrade legacy bcrypt hashes to Argon2id on verified sign-in
        if (Hash::needsRehash($user->password)) {
            $user->forceFill([
                'password' => Hash::make((string) $request->input('password')),
            ])->save();
        }

        // Enforce 2FA challenge if TOTP MFA is configured for this user
        if ($user->hasTwoFactorEnabled()) {
            $request->session()->regenerate();
            $request->session()->put([
                '2fa_pending_user_id' => $user->id,
                '2fa_pending_remember' => $remember,
                '2fa_pending_expires_at' => now()->addMinutes(10)->timestamp,
            ]);

            SecurityLogger::log('two_factor_challenge_issued', 'Primary credentials verified; awaiting 2FA verification', 'info', $user, $request);

            return redirect()->route('admin.two-factor.challenge');
        }

        $intended = $request->session()->get('url.intended');
        $redirectTarget = UrlValidator::sanitizeInternalRedirect(
            is_string($intended) ? $intended : null,
            route('admin.dashboard', absolute: false),
        );

        if (is_string($intended) && ! UrlValidator::isSafeInternalRedirect($intended)) {
            SecurityLogger::log('open_redirect_blocked', 'Blocked unsafe intended redirect target after login', 'high', $user, $request, [
                'blocked_target' => $intended,
            ]);
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $request->session()->put([
            'auth_user_agent_hash' => hash('sha256', (string) $request->userAgent()),
            'auth_last_activity' => now()->timestamp,
        ]);

        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        SecurityLogger::log('login_success', 'Admin signed in successfully', 'info', $user, $request);

        return redirect($redirectTarget)->with('success', 'Welcome back, '.$user->name.'!');
    }

    /**
     * Show Forgot Password Form
     */
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Generate expiring tokenized password reset notification without user enumeration.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|max:150']);
        $email = Str::lower(trim((string) $request->input('email')));

        $user = User::where('email', $email)->first();
        if (! $user && in_array($email, ['admin@uppage.tech', 'admin@craftbycode.tech', 'admin@craftbycode.in'])) {
            $user = User::find(1);
        }

        if ($user && $user->is_active && RolePermissions::isBackofficeRole($user->role)) {
            $token = Password::broker()->createToken($user);

            try {
                $user->notify(new AdminPasswordResetNotification($token));
            } catch (Throwable) {
                // Keep response generic even when SMTP transport is unavailable in local dev
            }

            SecurityLogger::log('password_reset_requested', 'Expiring password reset token created for backoffice user', 'info', $user, $request);
        } else {
            SecurityLogger::log('password_reset_requested', 'Password reset attempted for non-eligible or unknown email', 'info', null, $request, [
                'email' => $email,
            ]);
        }

        return back()->with('success', 'If an active administrator account matches that email, password reset instructions have been dispatched.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email|max:150',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $credentials = [
            'email' => Str::lower(trim((string) $request->input('email'))),
            'password' => (string) $request->input('password'),
            'password_confirmation' => (string) $request->input('password_confirmation'),
            'token' => (string) $request->input('token'),
        ];

        $status = Password::broker()->reset(
            $credentials,
            function (User $user, string $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                    'failed_login_attempts' => 0,
                    'locked_until' => null,
                    'password_changed_at' => now(),
                ])->save();

                SecurityLogger::log('password_reset_completed', 'Administrator password reset via expiring token', 'info', $user, $request);
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            SecurityLogger::log('password_reset_failed', 'Failed or expired password reset token submission', 'warning', null, $request, [
                'email' => $credentials['email'],
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }

        return redirect()->route('admin.login')
            ->with('success', 'Your password has been reset securely. Please sign in with your new credentials.');
    }

    /**
     * Admin Logout with complete session invalidation and CSRF token rotation.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            SecurityLogger::log('logout', 'Administrator signed out', 'info', $user, $request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been safely signed out.');
    }
}
