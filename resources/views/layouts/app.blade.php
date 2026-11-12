<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $brandName = \App\Models\WebsiteSetting::get('brand_name', 'CraftByCode');
        $defaultTitle = \App\Models\WebsiteSetting::get('meta_title_default', 'CraftByCode | MVP, SaaS & Custom Software Development for Global Startups');
        $defaultDesc = \App\Models\WebsiteSetting::get('meta_description_default', 'CraftByCode partners with global startups and scale-ups to design, build, and launch scalable SaaS platforms, MVPs, web & mobile apps, DevOps cloud infrastructure, and AI automation.');
        $defaultKeywords = \App\Models\WebsiteSetting::get('meta_keywords_default', 'startup software development, MVP development agency, SaaS product engineering, custom web application development, DevOps cloud engineering, AI automation for startups');
        $gscToken = trim((string) \App\Models\WebsiteSetting::get('google_site_verification', ''));
        $ga4Id = strtoupper(trim((string) \App\Models\WebsiteSetting::get('ga4_measurement_id', '')));
        $hasValidGa4 = (bool) preg_match('/^G-[A-Z0-9]{6,20}$/', $ga4Id);
        $rawOgImage = trim((string) \App\Models\WebsiteSetting::get('seo_og_image', 'assets/images/logo-transparent.png'));
        $defaultOgImage = \App\Security\UrlValidator::isSafeHttpUrl($rawOgImage)
            ? $rawOgImage
            : asset(ltrim($rawOgImage ?: 'assets/images/logo-transparent.png', '/'));

        $socialLinks = array_values(array_filter([
            \App\Models\WebsiteSetting::get('social_linkedin', ''),
            \App\Models\WebsiteSetting::get('social_twitter', ''),
            \App\Models\WebsiteSetting::get('social_github', ''),
            \App\Models\WebsiteSetting::get('social_facebook', ''),
        ], fn ($url) => \App\Security\UrlValidator::isSafeHttpUrl((string) $url)));

        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $brandName,
            'url' => route('home'),
            'logo' => asset(ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', 'assets/images/logo-icon-transparent.png'), '/')),
            'description' => $defaultDesc,
            'sameAs' => $socialLinks,
        ];

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $brandName,
            'url' => route('home'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('services.index') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    @endphp

    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultDesc)">
    <meta name="keywords" content="@yield('meta_keywords', $defaultKeywords)">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    @if($gscToken !== '' && preg_match('/^[A-Za-z0-9_\-]{10,128}$/', $gscToken))
        <meta name="google-site-verification" content="{{ $gscToken }}">
    @endif

    <!-- Open Graph / Social Meta -->
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', $defaultTitle)">
    <meta property="og:description" content="@yield('meta_description', $defaultDesc)">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $defaultTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $defaultDesc)">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json" nonce="{{ $cspNonce ?? '' }}">
        {!! json_encode($organizationSchema, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json" nonce="{{ $cspNonce ?? '' }}">
        {!! json_encode($websiteSchema, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @stack('schema')

    @if($hasValidGa4)
        <!-- Google Analytics 4 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}" nonce="{{ $cspNonce ?? '' }}"></script>
        <script nonce="{{ $cspNonce ?? '' }}">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $ga4Id }}', { anonymize_ip: true });
            document.addEventListener('submit', function (event) {
                var action = event.target && event.target.getAttribute ? (event.target.getAttribute('action') || '') : '';
                if (action.indexOf('/contact') !== -1) {
                    gtag('event', 'generate_lead', { event_category: 'engagement', event_label: 'contact_inquiry' });
                } else if (action.indexOf('/newsletter') !== -1) {
                    gtag('event', 'sign_up', { method: 'newsletter_footer' });
                }
            });
        </script>
    @endif

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @php $customFavicon = ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', ''), '/'); @endphp
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset($customFavicon && $customFavicon !== 'assets/images/logo-icon-transparent.png' ? $customFavicon : 'assets/images/favicon-48.png') }}">

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
