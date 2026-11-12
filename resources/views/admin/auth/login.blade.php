<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Portal Sign In | {{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset(ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', 'assets/images/logo-icon-transparent.png'), '/')) }}">

    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style nonce="{{ $cspNonce ?? '' }}">
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#080D19] text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-x-clip transition-colors duration-200">
    <!-- Ambient glowing backdrop -->
    <div class="hidden dark:block absolute -top-32 -left-32 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="hidden dark:block absolute -bottom-32 -right-32 w-96 h-96 bg-purple-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Theme Toggle Corner -->
        <div class="flex justify-end mb-4">
            <x-theme-toggle :compact="true" />
        </div>

        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block transition hover:opacity-90">
                <x-logo size="lg" :showTagline="true" />
            </a>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 font-medium">Enterprise Back-Office &amp; Security Control Portal</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl dark:shadow-2xl"
             x-data="{ showPass: false }">
            
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Sign in to your account</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Enter your authorized administrative credentials to continue.</p>

            <!-- Alerts -->
            @if(session('error'))
                <div class="p-3.5 mb-5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @elseif($errors->any())
                <div class="p-3.5 mb-5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit', [], false) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" required autofocus autocomplete="email"
                           value="{{ old('email') }}"
                           placeholder="you@company.com"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-700/80 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    @error('email')
                        <p class="text-rose-500 dark:text-rose-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password with Show/Hide Toggle -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Password</label>
                        <a href="{{ route('admin.password.request') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline transition">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                               placeholder="Enter password"
                               class="w-full pl-4 pr-12 py-3 bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-700/80 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <button type="button" @click="showPass = !showPass" 
                                class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-700 dark:hover:text-white transition"
                                aria-label="Toggle password visibility">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-500 dark:text-rose-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-50 dark:bg-slate-950 border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Keep me signed in</span>
                    </label>
                    <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                        Protected Portal
                    </span>
                </div>

                <!-- Submit Button -->
                <div class="pt-3">
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm tracking-wide transition shadow-lg shadow-blue-600/25">
                        Sign In to Dashboard
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Return to Public Website</span>
            </a>
        </div>
    </div>
</body>
</html>
