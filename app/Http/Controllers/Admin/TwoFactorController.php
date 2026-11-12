<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Security\SecurityLogger;
use App\Security\TotpService;
use App\Security\UrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function challengeForm(Request $request)
    {
        if (! $this->hasValidPendingChallenge($request)) {
            $this->clearPendingChallenge($request);

            return redirect()->route('admin.login')->with('error', 'Your two-factor verification session expired. Please sign in again.');
        }

        return view('admin.auth.two-factor-challenge');
    }

    public function verifyChallenge(Request $request, TotpService $totp)
    {
        if (! $this->hasValidPendingChallenge($request)) {
            $this->clearPendingChallenge($request);

            return redirect()->route('admin.login')->with('error', 'Your two-factor verification session expired. Please sign in again.');
        }

        $request->validate([
            'code' => 'nullable|string|max:32',
            'recovery_code' => 'nullable|string|max:32',
        ]);

        $userId = $request->session()->get('2fa_pending_user_id');
        $user = User::find($userId);

        if (! $user || ! $user->is_active || $user->isLockedOut() || ! $user->hasTwoFactorEnabled()) {
            $this->clearPendingChallenge($request);

            return redirect()->route('admin.login')->with('error', 'Unable to complete two-factor verification.');
        }

        $code = trim((string) $request->input('code', ''));
        $recoveryCode = trim((string) $request->input('recovery_code', ''));

        $verified = false;
        $method = 'totp';

        if ($code !== '' && $totp->verifyCode($user, (string) $user->two_factor_secret, $code)) {
            $verified = true;
        } elseif ($recoveryCode !== '' && $totp->consumeRecoveryCode($user, $recoveryCode)) {
            $verified = true;
            $method = 'recovery_code';
        }

        if (! $verified) {
            $attempts = $user->failed_login_attempts + 1;
            $updates = ['failed_login_attempts' => $attempts];
            if ($attempts >= 5) {
                $updates['locked_until'] = now()->addMinutes(15);
            }
            $user->forceFill($updates)->save();

            SecurityLogger::log('two_factor_failed', 'Failed 2FA verification attempt', 'warning', $user, $request, [
                'failed_attempts' => $attempts,
            ]);

            if ($user->isLockedOut()) {
                $this->clearPendingChallenge($request);

                return redirect()->route('admin.login')->with('error', 'Account temporarily locked after repeated verification failures.');
            }

            return back()->withErrors(['code' => 'Invalid authentication code or recovery code.']);
        }

        $remember = (bool) $request->session()->get('2fa_pending_remember', false);
        $intended = UrlValidator::sanitizeInternalRedirect(
            $request->session()->get('url.intended'),
            route('admin.dashboard', absolute: false),
        );

        $this->clearPendingChallenge($request);

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $request->session()->put([
            '2fa_verified' => true,
            'auth_user_agent_hash' => hash('sha256', (string) $request->userAgent()),
            'auth_last_activity' => now()->timestamp,
        ]);

        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        SecurityLogger::log('login_success', "Admin signed in with 2FA ({$method})", 'info', $user, $request);

        return redirect($intended)->with('success', 'Two-factor authentication verified. Welcome back!');
    }

    public function initiateSetup(Request $request, TotpService $totp)
    {
        $user = Auth::user();
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('admin.profile.index')->with('info', 'Two-factor authentication is already active on your account.');
        }

        $secret = $totp->generateSecret();
        $request->session()->put('2fa_setup_secret', $secret);

        return redirect()->route('admin.profile.index')->with('info', 'Scan the QR code with your authenticator app and enter the 6-digit code to activate 2FA.');
    }

    public function confirmSetup(Request $request, TotpService $totp)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'code' => 'required|string|max:16',
        ]);

        $secret = $request->session()->get('2fa_setup_secret');
        if (! is_string($secret) || $secret === '') {
            return redirect()->route('admin.profile.index')->with('error', '2FA setup session expired. Please initiate setup again.');
        }

        $user = Auth::user();
        if (! $totp->verifyCode($user, $secret, (string) $request->input('code'))) {
            SecurityLogger::log('two_factor_failed', 'Failed 2FA enrollment confirmation code', 'warning', $user, $request);

            return back()->withErrors(['code' => 'The verification code did not match. Ensure your device clock is synchronized.']);
        }

        $recovery = $totp->generateRecoveryCodes();

        $user->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => $recovery['hashed'],
            'two_factor_confirmed_at' => now(),
        ])->save();

        $request->session()->forget('2fa_setup_secret');
        $request->session()->put('2fa_verified', true);

        SecurityLogger::log('two_factor_enabled', 'Admin enabled TOTP two-factor authentication', 'info', $user, $request);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Two-factor authentication is now enabled. Store your recovery codes in a safe place.')
            ->with('recovery_codes_plain', $recovery['plain']);
    }

    public function regenerateRecoveryCodes(Request $request, TotpService $totp)
    {
        $request->validate([
            'current_password' => 'required|current_password',
        ]);

        $user = Auth::user();
        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('admin.profile.index')->with('error', 'Enable 2FA before regenerating recovery codes.');
        }

        $recovery = $totp->generateRecoveryCodes();
        $user->forceFill([
            'two_factor_recovery_codes' => $recovery['hashed'],
        ])->save();

        SecurityLogger::log('two_factor_recovery_regenerated', 'Admin regenerated 2FA recovery codes', 'warning', $user, $request);

        return redirect()->route('admin.profile.index')
            ->with('success', 'New recovery codes generated. Previous recovery codes are invalidated.')
            ->with('recovery_codes_plain', $recovery['plain']);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
        ]);

        $user = Auth::user();
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        $request->session()->forget(['2fa_verified', '2fa_setup_secret']);

        SecurityLogger::log('two_factor_disabled', 'Admin disabled TOTP two-factor authentication', 'warning', $user, $request);

        return redirect()->route('admin.profile.index')->with('success', 'Two-factor authentication has been disabled.');
    }

    private function hasValidPendingChallenge(Request $request): bool
    {
        $userId = $request->session()->get('2fa_pending_user_id');
        $expiresAt = (int) $request->session()->get('2fa_pending_expires_at', 0);

        return $userId && $expiresAt >= now()->timestamp;
    }

    private function clearPendingChallenge(Request $request): void
    {
        $request->session()->forget([
            '2fa_pending_user_id',
            '2fa_pending_remember',
            '2fa_pending_expires_at',
        ]);
    }
}
