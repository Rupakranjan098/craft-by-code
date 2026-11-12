@extends('layouts.admin')

@section('title', 'Admin Profile & 2FA Security')
@section('header_title', 'Account & Security')

@section('content')
    <div class="max-w-5xl space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Admin Account &amp; MFA Security</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage profile info, strong password policy, and TOTP two-factor authentication</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-bold {{ $user->hasTwoFactorEnabled() ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300' : 'bg-amber-50 dark:bg-amber-950/60 border-amber-200 dark:border-amber-700 text-amber-700 dark:text-amber-300' }}">
                <x-icon name="shield-check" class="w-4 h-4" />
                <span>2FA {{ $user->hasTwoFactorEnabled() ? 'Active & Protected' : 'Recommended (Disabled)' }}</span>
            </div>
        </div>

        @if(session('recovery_codes_plain'))
            <div class="p-6 rounded-3xl bg-amber-50 dark:bg-amber-950/50 border border-amber-200 dark:border-amber-700 space-y-3">
                <h3 class="text-sm font-bold text-amber-900 dark:text-amber-200">Save Your One-Time Recovery Codes Immediately</h3>
                <p class="text-xs text-amber-800 dark:text-amber-300">Each code works once if you lose access to your authenticator app. Store them in a secure password manager — they will not be shown again.</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1">
                    @foreach(session('recovery_codes_plain') as $recoveryCode)
                        <code class="px-3 py-2 rounded-lg bg-white dark:bg-slate-900 border border-amber-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-900 dark:text-slate-100 text-center">{{ $recoveryCode }}</code>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            <!-- Profile Info Card -->
            <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <x-icon name="shield-check" class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Profile Information</h2>
                        <p class="text-xs text-slate-400">Role: <span class="uppercase font-bold text-blue-600">{{ $user->role }}</span></p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Save Profile Details
                    </button>
                </div>
            </form>

            <!-- Change Password Card -->
            <form action="{{ route('admin.profile.password') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                        <x-icon name="shield" class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Change Password</h2>
                        <p class="text-xs text-slate-400">Min 12 chars with uppercase, lowercase, number &amp; symbol</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Password *</label>
                    <input type="password" name="current_password" required placeholder="••••••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">New Strong Password (min 12 chars) *</label>
                    <input type="password" name="password" required placeholder="••••••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Update Password &amp; Rotate Sessions
                    </button>
                </div>
            </form>
        </div>

        <!-- Two-Factor Authentication Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Multi-Factor Authentication (TOTP 2FA)</h2>
                    <p class="text-xs text-slate-500">Protect administrator access using Google Authenticator, 1Password, or Authy.</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->hasTwoFactorEnabled() ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $user->hasTwoFactorEnabled() ? 'Enabled' : 'Not Configured' }}
                </span>
            </div>

            @if($user->hasTwoFactorEnabled())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <form action="{{ route('admin.profile.two-factor.recovery') }}" method="POST" class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        @csrf
                        <h3 class="text-sm font-bold text-slate-900">Regenerate Recovery Codes</h3>
                        <p class="text-xs text-slate-500">Invalidates all unused recovery codes and issues 8 fresh one-time backup codes.</p>
                        <input type="password" name="current_password" required placeholder="Confirm current password"
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold transition">
                            Regenerate Codes
                        </button>
                    </form>

                    <form action="{{ route('admin.profile.two-factor.disable') }}" method="POST" class="p-5 rounded-2xl bg-rose-50/50 dark:bg-rose-950/30 border border-rose-200/70 space-y-4">
                        @csrf
                        @method('DELETE')
                        <h3 class="text-sm font-bold text-rose-700 dark:text-rose-300">Disable Two-Factor Authentication</h3>
                        <p class="text-xs text-slate-500">Only disable 2FA if you are migrating to a new hardware token or authenticator device.</p>
                        <input type="password" name="current_password" required placeholder="Confirm current password"
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition">
                            Disable 2FA
                        </button>
                    </form>
                </div>
            @elseif($twoFactorSetup)
                <div class="grid grid-cols-1 md:grid-cols-[auto_1fr] gap-8 items-center">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 inline-block mx-auto">
                        <img src="{{ $twoFactorSetup['qr_data_uri'] }}" alt="TOTP 2FA QR Code" class="w-48 h-48">
                    </div>

                    <form action="{{ route('admin.profile.two-factor.confirm') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Manual Setup Secret</span>
                            <code class="px-3 py-1.5 rounded-lg bg-slate-100 text-xs font-mono font-bold text-slate-900 select-all">{{ $twoFactorSetup['secret'] }}</code>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">6-Digit App Code *</label>
                                <input type="text" name="code" required placeholder="123456" inputmode="numeric"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Current Password *</label>
                                <input type="password" name="current_password" required placeholder="Verify password"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            </div>
                        </div>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition shadow">
                            Confirm &amp; Activate 2FA
                        </button>
                    </form>
                </div>
            @else
                <form action="{{ route('admin.profile.two-factor.setup') }}" method="POST" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p class="text-xs text-slate-600 max-w-xl">
                        When enabled, you will be prompted for a secure 6-digit verification code during sign-in, plus receive 8 single-use recovery codes.
                    </p>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow whitespace-nowrap">
                        Set Up 2FA Authenticator
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
