<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $defaultTitle = \App\Models\WebsiteSetting::get('meta_title_default', 'UpPage Technology | Building Digital Solutions. Empowering Businesses.');
        $defaultDesc = \App\Models\WebsiteSetting::get('meta_description_default', 'UpPage Technology is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.');
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

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-slate-900 antialiased selection:bg-blue-600 selection:text-white min-h-screen flex flex-col relative">
    <!-- Background Side Bubbles & Glows across all pages -->
    <x-background-bubbles />

    <!-- Navbar -->
    <x-navbar />

    <!-- Flash notifications -->
    <x-flash />

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    @stack('scripts')
</body>
</html>

