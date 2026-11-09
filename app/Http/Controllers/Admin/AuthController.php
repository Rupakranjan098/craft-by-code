<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show modern admin login form
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle admin login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Too many login attempts. Please try again in {$seconds} seconds.");
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->with('error', 'Access restricted to administrators only.');
            }

            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        RateLimiter::hit($throttleKey);

        return back()->withInput($request->only('email', 'remember'))->with('error', 'The provided credentials do not match our records.');
    }

    /**
     * Show Forgot Password Form
     */
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Process Forgot Password Request
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // For demonstration and security, inform that if the email exists, a link was dispatched
        return back()->with('success', 'If this email belongs to an administrator, a password reset authorization has been recorded.');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been safely signed out.');
    }
}

