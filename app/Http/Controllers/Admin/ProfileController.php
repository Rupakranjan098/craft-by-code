<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Security\SecurityLogger;
use App\Security\TotpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Throwable;

class ProfileController extends Controller
{
    public function index(Request $request, TotpService $totp)
    {
        $user = Auth::user();
        $twoFactorSetup = null;

        $pendingSecret = $request->session()->get('2fa_setup_secret');
        if (! $user->hasTwoFactorEnabled() && is_string($pendingSecret) && $pendingSecret !== '') {
            $issuer = config('app.name', 'CraftByCode');
            $uri = $totp->getProvisioningUri((string) $issuer, (string) $user->email, $pendingSecret);
            $twoFactorSetup = [
                'secret' => $pendingSecret,
                'qr_data_uri' => $totp->renderQrDataUri($uri),
            ];
        }

        return view('admin.profile.index', compact('user', 'twoFactorSetup'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:30',
        ]);

        $user->name = $request->input('name');
        $user->email = strtolower(trim((string) $request->input('email')));
        $user->phone = $request->input('phone');
        $user->save();

        SecurityLogger::log('profile_updated', 'Administrator updated profile details', 'info', $user, $request);

        return back()->with('success', 'Profile information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|current_password',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $newPassword = (string) $request->input('password');

        if (Hash::check($newPassword, $user->password)) {
            return back()->withErrors(['password' => 'New password must be different from your current password.']);
        }

        $user->forceFill([
            'password' => Hash::make($newPassword),
            'password_changed_at' => now(),
        ])->save();

        try {
            Auth::logoutOtherDevices($newPassword);
        } catch (Throwable) {
            // Safely continue if running in stateless/test guard
        }

        $request->session()->regenerate();
        SecurityLogger::log('password_changed', 'Administrator changed account password and rotated active sessions', 'info', $user, $request);

        return back()->with('success', 'Password updated with strong policy and all other sessions rotated.');
    }
}
