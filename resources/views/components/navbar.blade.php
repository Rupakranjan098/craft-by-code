@php
    $navServices = \App\Models\Service::active()->orderBy('order')->take(6)->get();
@endphp

<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        class="sticky top-0 z-40 w-full pt-3 sm:pt-4 pb-2 px-3 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300">
    <div :class="scrolled
            ? 'bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl shadow-[0_12px_36px_rgba(15,23,42,0.08)] dark:shadow-[0_12px_36px_rgba(0,0,0,0.45)] border-slate-200/80 dark:border-slate-700/80'
            : 'bg-white/90 dark:bg-slate-900/85 backdrop-blur-md shadow-[0_8px_30px_rgba(15,23,42,0.05)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.35)] border-slate-200/60 dark:border-slate-800'"
         class="pointer-events-auto max-w-6xl mx-auto rounded-full border transition-all duration-300 px-4 sm:px-6 lg:px-8">

        <!-- Desktop Left-Logo Floating Pill Navigation -->
        <div class="hidden lg:flex items-center justify-between h-[68px] gap-6">
            <!-- Left Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 transition hover:opacity-90">
                <x-logo size="md" />
            </a>

            <!-- Right Navigation Links + Day/Night + CTA -->
            <div class="flex items-center justify-end gap-5 xl:gap-7">
                <nav class="flex items-center gap-5 xl:gap-6">
                    <a href="{{ route('home') }}" 
                       class="text-sm xl:text-[15px] whitespace-nowrap transition {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}">
                        Home
                    </a>
                    <!-- Services Multi-Page Dropdown -->
                    <div x-data="{ servicesDropdownOpen: false }" 
                         @mouseenter="servicesDropdownOpen = true" 
                         @mouseleave="servicesDropdownOpen = false" 
                         @click.away="servicesDropdownOpen = false"
                         @keydown.escape.window="servicesDropdownOpen = false"
                         class="relative">
                        <a href="{{ route('services.index') }}" 
                           class="inline-flex items-center gap-1 text-sm xl:text-[15px] whitespace-nowrap transition py-1 {{ request()->routeIs('services.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}"
                           aria-expanded="servicesDropdownOpen"
                           aria-haspopup="true">
                            <span>Services</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': servicesDropdownOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>

                        <!-- Dropdown Menu -->
                        <div x-show="servicesDropdownOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             x-cloak
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-[580px] max-w-[90vw] p-3 rounded-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 shadow-2xl z-50"
                             style="width: 580px; min-width: 320px; max-width: min(580px, calc(100vw - 2rem));">
                            
                            <div class="px-3 py-2 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Our Specialized Services</span>
                                <span class="text-[10px] font-semibold text-blue-600 dark:text-blue-400">Direct Page Access</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 p-2" style="width: 100%;">
                                @foreach($navServices as $nService)
                                    <a href="{{ route('services.show', $nService->slug) }}" 
                                       class="group flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/80 transition {{ request()->is('services/'.$nService->slug) ? 'bg-blue-50/70 dark:bg-blue-950/40 text-blue-600' : '' }}"
                                       style="min-width: 0;">
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition"
                                             style="flex-shrink: 0; width: 36px; height: 36px;">
                                            <x-icon :name="$nService->icon" class="w-4 h-4" />
                                        </div>
                                        <div class="min-w-0 flex-1" style="min-width: 0;">
                                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition truncate leading-snug">
                                                {{ $nService->title }}
                                            </div>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5 leading-snug">
                                                {{ $nService->short_description }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="pt-2 px-3 pb-1 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                                <a href="{{ route('services.index') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                    <span>View All Services Overview</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                                <a href="{{ route('contact') }}" class="text-[11px] font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                                    Inquire Directly &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('portfolio.index') }}" 
                       class="text-sm xl:text-[15px] whitespace-nowrap transition {{ request()->routeIs('portfolio.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}">
                        Portfolio
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       class="text-sm xl:text-[15px] whitespace-nowrap transition {{ request()->routeIs('blog.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}">
                        Blog
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-sm xl:text-[15px] whitespace-nowrap transition {{ request()->routeIs('about') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}">
                        About Us
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="text-sm xl:text-[15px] whitespace-nowrap transition {{ request()->routeIs('contact') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white font-medium' }}">
                        Contact
                    </a>
                </nav>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <x-theme-toggle :compact="true" />
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center justify-center px-5 xl:px-6 py-2.5 text-sm font-semibold text-white bg-[#0B172A] dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-500 rounded-full transition-all duration-200 shadow-sm hover:shadow-md hover:scale-[1.02] whitespace-nowrap">
                        Get Started
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile & Tablet Bar -->
        <div class="flex lg:hidden items-center justify-between h-14 sm:h-16 gap-2">
            <a href="{{ route('home') }}" class="flex items-center transition hover:opacity-95 min-w-0">
                <x-logo size="sm" />
            </a>

            <div class="flex items-center gap-2 flex-shrink-0">
                <x-theme-toggle :compact="true" />
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="p-2 rounded-full text-slate-700 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none"
                        aria-label="Toggle navigation">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden pointer-events-auto max-w-6xl mx-auto mt-3 rounded-3xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-slate-200/80 dark:border-slate-700 shadow-2xl px-5 pt-4 pb-6 space-y-1">
        
        <div class="flex items-center justify-between pb-3 mb-2 border-b border-slate-100 dark:border-slate-800">
            <x-logo size="sm" />
            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Navigation</span>
        </div>

        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Home
        </a>
        <!-- Mobile Expandable Services Accordion -->
        <div x-data="{ mobileServicesOpen: {{ request()->routeIs('services.*') ? 'true' : 'false' }} }" class="rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('services.*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <a href="{{ route('services.index') }}" class="flex-1">
                    Services
                </a>
                <button @click="mobileServicesOpen = !mobileServicesOpen" type="button" class="p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none" aria-label="Toggle Services list">
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': mobileServicesOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            <div x-show="mobileServicesOpen" x-cloak class="mt-1 pl-3 pr-2 py-1.5 space-y-1 bg-slate-50/70 dark:bg-slate-950/40 rounded-xl">
                <a href="{{ route('services.index') }}" class="block px-3 py-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                    &rarr; All Services Overview
                </a>
                @foreach($navServices as $nService)
                    <a href="{{ route('services.show', $nService->slug) }}" 
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium {{ request()->is('services/' . $nService->slug) ? 'bg-blue-100/70 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-slate-800' }} transition">
                        <div class="w-5 h-5 rounded bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                            <x-icon :name="$nService->icon" class="w-3 h-3" />
                        </div>
                        <span class="truncate">{{ $nService->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <a href="{{ route('portfolio.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('portfolio.*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Portfolio
        </a>
        <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('about') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            About Us
        </a>
        <a href="{{ route('blog.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('blog.*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Blog
        </a>
        <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('contact') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Contact
        </a>
        <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2.5">
            <div class="flex items-center justify-between px-2 py-1">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Appearance</span>
                <x-theme-toggle :label="true" />
            </div>
            <a href="{{ route('contact') }}" class="w-full text-center px-5 py-3 rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-semibold text-sm hover:bg-blue-600 dark:hover:bg-blue-500 transition shadow">
                Get Started
            </a>
            <a href="{{ route('admin.login') }}" class="text-center text-xs text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 py-1">
                Admin Portal
            </a>
        </div>
    </div>
</header>
