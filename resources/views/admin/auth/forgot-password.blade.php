<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password | {{ config('app.name', 'CraftByCode') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset(ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', 'assets/images/logo-icon-transparent.png'), '/')) }}">
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-[#080D19] text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-4 transition-colors duration-200">
    <div class="w-full max-w-md">
        <div class="flex justify-end mb-4">
            <x-theme-toggle :compact="true" />
        </div>

        <div class="text-center mb-8">
            <x-logo size="lg" />
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Password Recovery</p>
        </div>

        <div class="bg-white dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl dark:shadow-2xl">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Reset Password</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Enter your email address and we'll dispatch a time-limited reset token if an active administrator account matches.</p>

            @if(session('success'))
                <div class="p-3.5 mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 mb-5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.password.email', [], false) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@company.com"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm transition">
                    Send Password Reset Link
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline transition">Return to login</a>
            </div>
        </div>
    </div>
</body>
</html>
