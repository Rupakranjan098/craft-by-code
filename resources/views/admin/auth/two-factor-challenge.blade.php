<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two-Factor Verification | {{ config('app.name', 'CraftByCode') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-[#080D19] text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="flex justify-end mb-4">
            <x-theme-toggle :compact="true" />
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl" x-data="{ useRecovery: false }">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4">
                <x-icon name="shield-check" class="w-6 h-6" />
            </div>

            <h1 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Multi-Factor Authentication</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Enter the 6-digit verification code from your authenticator app or use a one-time recovery code.</p>

            @if($errors->any())
                <div class="p-3.5 mb-5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.two-factor.verify', [], false) }}" method="POST" class="space-y-4">
                @csrf

                <div x-show="!useRecovery">
                    <label for="code" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Authenticator Code (6 Digits)</label>
                    <input type="text" id="code" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="10" placeholder="123456"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm tracking-widest font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div x-show="useRecovery" x-cloak>
                    <label for="recovery_code" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">One-Time Recovery Code</label>
                    <input type="text" id="recovery_code" name="recovery_code" placeholder="XXXX-XXXX-XXXX"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm uppercase font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="useRecovery = !useRecovery" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                        <span x-show="!useRecovery">Use a recovery code instead</span>
                        <span x-show="useRecovery" x-cloak>Use authenticator app code</span>
                    </button>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm transition shadow">
                    Verify &amp; Continue
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="text-xs text-slate-500 dark:text-slate-400 hover:underline">Cancel and return to sign in</a>
            </div>
        </div>
    </div>
</body>
</html>

