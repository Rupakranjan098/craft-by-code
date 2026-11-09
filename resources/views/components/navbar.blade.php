<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-slate-100' : 'bg-transparent border-transparent'"
        class="sticky top-0 z-40 w-full border-b transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center transition hover:opacity-95">
                <x-logo size="md" />
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="{{ route('home') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Home
                </a>
                <a href="{{ route('services.index') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('services.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Services
                </a>
                <a href="{{ route('solutions.index') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('solutions.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Digital Solutions
                </a>
                <a href="{{ route('portfolio.index') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('portfolio.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Portfolio
                </a>
                <a href="{{ route('about') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('about') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    About Us
                </a>
                <a href="{{ route('blog.index') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('blog.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Blog
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-full transition {{ request()->routeIs('contact') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                    Contact
                </a>
            </nav>

            <!-- Right CTA Button Group -->
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('admin.hrms.dashboard') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-600 rounded-full border border-slate-200/90 transition shadow-sm hover:border-blue-300 group"
                   title="HRMS Enterprise Portal (Admin Only)">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <svg class="w-3.5 h-3.5 text-blue-600 transition group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>HRMS</span>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-blue-100 text-blue-700 uppercase tracking-wider">Admin</span>
                </a>

                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-slate-900 hover:bg-blue-600 rounded-full transition-all duration-200 shadow-sm hover:shadow-md hover:scale-[1.02] group">
                    <span>Get Started</span>
                    <svg class="w-4 h-4 ml-1.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="p-2 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none"
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
         class="md:hidden bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-xl px-5 pt-4 pb-6 space-y-1">
        
        <div class="flex items-center justify-between pb-3 mb-2 border-b border-slate-100">
            <x-logo size="sm" />
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Navigation</span>
        </div>

        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Home
        </a>
        <a href="{{ route('services.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('services.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Services
        </a>
        <a href="{{ route('solutions.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('solutions.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Digital Solutions
        </a>
        <a href="{{ route('portfolio.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('portfolio.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Portfolio
        </a>
        <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            About Us
        </a>
        <a href="{{ route('blog.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('blog.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Blog
        </a>
        <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
            Contact
        </a>
        <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2">
            <a href="{{ route('admin.hrms.dashboard') }}" class="flex items-center justify-center gap-2 w-full text-center px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 font-bold text-xs hover:bg-blue-100 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>HRMS Portal (Admin Access Only)</span>
            </a>
            <a href="{{ route('contact') }}" class="w-full text-center px-5 py-3 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-blue-600 transition shadow">
                Get Started
            </a>
            <a href="{{ route('admin.login') }}" class="text-center text-xs text-slate-400 hover:text-slate-600 py-1">
                Admin Portal
            </a>
        </div>
    </div>
</header>

