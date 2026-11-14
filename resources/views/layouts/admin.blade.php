<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | {{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }} Control Center</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('assets/images/favicon-48.png') }}">

    <!-- Theme initializer -->
    <x-theme-script />

    <!-- Vite Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style nonce="{{ $cspNonce ?? '' }}">
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="admin-shell bg-slate-100 dark:bg-[#080D19] text-slate-800 dark:text-slate-100 antialiased min-h-screen flex overflow-x-clip transition-colors duration-200" x-data="{ sidebarOpen: false }">

    <!-- Left Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#080D19] text-slate-300 flex flex-col justify-between transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Sidebar Header / Logo -->
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-logo size="sm" dark="true" />
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5 text-xs font-semibold">
            <div class="px-3 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-500">Overview</div>
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="browser" class="w-4 h-4" />
                <span>Dashboard</span>
            </a>

            <div class="px-3 pt-5 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-500">Modules</div>
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.services.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="code" class="w-4 h-4" />
                <span>Manage Services</span>
            </a>
            <a href="{{ route('admin.projects.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.projects.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="briefcase" class="w-4 h-4" />
                <span>Portfolio / Projects</span>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="star" class="w-4 h-4" />
                <span>Client Testimonials</span>
            </a>
            <a href="{{ route('admin.blog.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.blog.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="sparkles" class="w-4 h-4" />
                <span>Blog & Articles</span>
            </a>

            <div class="px-3 pt-5 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-500">Customer Inquiries</div>
            <a href="{{ route('admin.inquiries.index') }}" 
               class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <div class="flex items-center gap-3">
                    <x-icon name="mail" class="w-4 h-4" />
                    <span>Inquiries</span>
                </div>
                @php
                    $unreadCount = \App\Models\ContactInquiry::where('status', 'new')->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            @if(Auth::user()?->hasPermission('agreements.view'))
                <div class="px-3 pt-5 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-500">Legal &amp; Contracts</div>
                <a href="{{ route('admin.agreements.index') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.agreements.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="flex items-center gap-3">
                        <x-icon name="file-text" class="w-4 h-4" />
                        <span>Agreements</span>
                    </div>
                    @php
                        $pendingAgreementsCount = \App\Models\Agreement::whereIn('status', ['pending_signature', 'estamp_pending'])->count();
                    @endphp
                    @if($pendingAgreementsCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950">
                            {{ $pendingAgreementsCount }}
                        </span>
                    @endif
                </a>
            @endif

            <div class="px-3 pt-5 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-500">Website Management</div>
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="edit" class="w-4 h-4" />
                <span>Website Content</span>
            </a>
            <a href="{{ route('admin.about.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.about.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="shield" class="w-4 h-4" />
                <span>About Us Content</span>
            </a>
            <a href="{{ route('admin.seo.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.seo.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="globe" class="w-4 h-4" />
                <span>SEO & Meta</span>
            </a>
            <a href="{{ route('admin.profile.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <x-icon name="shield-check" class="w-4 h-4" />
                <span>Profile &amp; 2FA Security</span>
            </a>

            @if(Auth::user()?->hasPermission('security.view'))
                <a href="{{ route('admin.security.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.security.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <x-icon name="shield" class="w-4 h-4" />
                    <span>Security Center</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">
                    {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->name ?? 'Admin User' }}</span>
                    <span class="text-[10px] text-slate-400 block truncate">{{ Auth::user()->email ?? 'admin@craftbycode.tech' }}</span>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-400 transition" title="Sign Out">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Backdrop for mobile drawer -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-cloak 
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen min-w-0 lg:pl-64">
        <!-- Topbar -->
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-8 gap-3">
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg flex-shrink-0" aria-label="Toggle sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">
                    @yield('header_title', 'Control Center')
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                <x-theme-toggle :compact="true" />
                <!-- View Live Site Button -->
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <x-icon name="eye" class="w-3.5 h-3.5" />
                    <span class="hidden sm:inline">View Live Site</span>
                </a>

                <!-- Inquiries notification badge -->
                <a href="{{ route('admin.inquiries.index') }}" class="relative p-2 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    <x-icon name="mail" class="w-5 h-5" />
                    @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-white dark:ring-slate-900"></span>
                    @endif
                </a>

                <!-- Profile avatar -->
                <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-2 pl-2 border-l border-slate-200 dark:border-slate-700">
                    <div class="w-8 h-8 rounded-full bg-slate-900 dark:bg-blue-600 text-white font-bold text-xs flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                </a>
            </div>
        </header>

        <!-- Flash alerts -->
        <x-flash />

        <!-- Page Body Content -->
        <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

