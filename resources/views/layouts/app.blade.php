<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $defaultTitle = \App\Models\WebsiteSetting::get('meta_title_default', 'CraftByCode | Building Digital Solutions. Empowering Businesses.');
        $defaultDesc = \App\Models\WebsiteSetting::get('meta_description_default', 'CraftByCode is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.');
        $defaultKeywords = \App\Models\WebsiteSetting::get('meta_keywords_default', 'software development, web design, mobile apps, AI automation, custom software, digital solutions');
    @endphp

    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultDesc)">
    <meta name="keywords" content="@yield('meta_keywords', $defaultKeywords)">

    <!-- Open Graph / Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $defaultTitle)">
    <meta property="og:description" content="@yield('meta_description', $defaultDesc)">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset(ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', 'assets/images/logo-icon-transparent.png'), '/')) }}">

    <!-- Apply saved Day/Night theme before CSS render to eliminate FOUC -->
    <x-theme-script />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style nonce="{{ $cspNonce ?? '' }}">
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-white dark:bg-[#080D19] text-slate-900 dark:text-slate-100 antialiased selection:bg-blue-600 selection:text-white min-h-screen flex flex-col relative isolate overflow-x-clip transition-colors duration-200">
    <!-- Subtle architectural grid backdrop fading cleanly below header/hero -->
    <div class="hero-grid-bg pointer-events-none absolute inset-x-0 top-0 h-[560px] z-0 [mask-image:linear-gradient(to_bottom,rgba(0,0,0,0.9)_0%,rgba(0,0,0,0.4)_65%,transparent_100%)]" aria-hidden="true"></div>

    <!-- Navbar -->
    <x-navbar />

    <!-- Flash notifications -->
    <x-flash />

    <!-- Main Content -->
    <main class="flex-grow relative z-10 min-w-0">
        @yield('content')
    </main>

    <!-- Footer -->
    <div class="relative z-10">
        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
