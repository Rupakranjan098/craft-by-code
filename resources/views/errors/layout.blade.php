<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('code') — @yield('title') | {{ config('app.name', 'CraftByCode') }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-[#080D19] text-slate-900 dark:text-slate-100 antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="max-w-lg w-full text-center p-8 sm:p-10 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xl">
        <div class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 text-xs font-bold tracking-wider uppercase mb-4">
            Error @yield('code')
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mb-3">@yield('title')</h1>
        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-8">@yield('message')</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-900 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-500 text-white text-xs font-bold transition">
                Return Home
            </a>
            <x-theme-toggle :label="true" />
        </div>
    </div>
</body>
</html>

