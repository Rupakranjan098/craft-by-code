@extends('layouts.app')

@php
    $heroH1 = \App\Models\WebsiteSetting::get('hero_headline_1', 'WE DESIGN.');
    $heroH2 = \App\Models\WebsiteSetting::get('hero_headline_2', 'WE CODE.');
    $heroHGrad = \App\Models\WebsiteSetting::get('hero_headline_gradient', 'WE INNOVATE.');
    $heroSub = \App\Models\WebsiteSetting::get('hero_subtitle', 'We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.');
    $heroBadge = \App\Models\WebsiteSetting::get('brand_badge', 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE');
    $statClients = \App\Models\WebsiteSetting::get('stat_clients_count', '50+');
    $statProjects = \App\Models\WebsiteSetting::get('stat_projects_count', '120+');
    $statYears = \App\Models\WebsiteSetting::get('stat_years_count', '5+');
    $statSat = \App\Models\WebsiteSetting::get('stat_satisfaction_count', '98%');
@endphp

@section('content')
    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-16 lg:pb-28 gradient-hero">
        <!-- Floating 3D Elements Decorative (Brain & Terminal) -->
        <div class="hidden lg:block absolute left-12 top-28 animate-bounce transition duration-1000" style="animation-duration: 4s;">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-xl border border-slate-100 flex items-center justify-center p-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 0 0-4 4v1a4 4 0 0 0 4 4 4 4 0 0 0 4-4V6a4 4 0 0 0-4-4Z"/>
                        <path d="M6 10a4 4 0 0 0-4 4v1a4 4 0 0 0 4 4 4 4 0 0 0 4-4v-1a4 4 0 0 0-4-4Z"/>
                        <path d="M18 10a4 4 0 0 0-4 4v1a4 4 0 0 0 4 4 4 4 0 0 0 4-4v-1a4 4 0 0 0-4-4Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="hidden lg:block absolute right-16 top-24 animate-pulse transition duration-1000" style="animation-duration: 5s;">
            <div class="w-20 h-20 rounded-2xl bg-white shadow-2xl border border-slate-100 flex flex-col justify-between p-3.5">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                </div>
                <div class="font-mono text-[11px] font-bold text-purple-600 bg-purple-50 rounded px-1.5 py-0.5">
                    &gt;_ code
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50/80 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-8">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                <span>{{ $heroBadge }}</span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight text-slate-900 leading-[1.08] mb-6">
                {{ $heroH1 }}<br>
                {{ $heroH2 }}<br>
                <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $heroHGrad }}</span>
            </h1>

            <!-- Subtitle -->
            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-600 font-normal leading-relaxed mb-10">
                {{ $heroSub }}
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('services.index') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-slate-950 text-white font-semibold text-sm hover:bg-blue-600 transition shadow-sm hover:shadow-md group">
                    <span>Explore Services</span>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-white text-slate-800 font-semibold text-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition shadow-sm group">
                    <span>Let's Talk</span>
                    <svg class="w-4 h-4 ml-2 text-slate-500 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 4 Feature Highlights Row -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 lg:mt-20">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Clean Code -->
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Clean Code</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Scalable, maintainable and well-structured code.</p>
                    </div>
                </div>

                <!-- Creative Design -->
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m18 2 4 4-12 12H6v-4L18 2z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Creative Design</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Pixel-perfect designs that inspire and engage.</p>
                    </div>
                </div>

                <!-- Smart Solutions -->
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/><circle cx="12" cy="12" r="5"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Smart Solutions</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Solving complex problems with smart thinking.</p>
                    </div>
                </div>

                <!-- Future Ready -->
                <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m12 15-3-3m0 0 3-3m-3 3h12"/><path d="M4.5 16.5c-1.5 1.26-2 3.5-2 3.5s2.24-.5 3.5-2"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Future Ready</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Innovative solutions for a digital-first world.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. TRUSTED BY GLOBAL BRANDS -->
    <section class="py-12 border-y border-slate-100 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-slate-400 mb-8">
                Trusted by global brands & fast-growing startups
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-14 lg:gap-20 opacity-60 hover:opacity-90 transition-opacity">
                <!-- Google -->
                <div class="flex items-center gap-2 font-bold text-xl text-slate-700">
                    <span class="tracking-tight">Google</span>
                </div>
                <!-- Microsoft -->
                <div class="flex items-center gap-2 font-semibold text-lg text-slate-700">
                    <div class="grid grid-cols-2 gap-0.5 w-4 h-4">
                        <div class="bg-red-500"></div><div class="bg-green-500"></div>
                        <div class="bg-blue-500"></div><div class="bg-yellow-500"></div>
                    </div>
                    <span>Microsoft</span>
                </div>
                <!-- AWS -->
                <div class="font-bold text-xl text-slate-700">
                    aws
                </div>
                <!-- Slack -->
                <div class="font-bold text-lg text-slate-700">
                    #slack
                </div>
                <!-- Shopify -->
                <div class="font-bold text-lg text-slate-700">
                    shopify
                </div>
                <!-- Stripe -->
                <div class="font-bold text-xl text-slate-700">
                    stripe
                </div>
            </div>
        </div>
    </section>

    <!-- 3. OUR SERVICES SECTION -->
    <section class="py-20 lg:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-2">Our Services</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    End-to-end solutions for your digital success
                </h2>
            </div>
            <a href="{{ route('services.index') }}" 
               class="mt-4 md:mt-0 inline-flex items-center text-sm font-semibold text-slate-700 hover:text-blue-600 group">
                <span>View All Services</span>
                <svg class="w-4 h-4 ml-1.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredServices as $service)
                <div class="group relative p-7 rounded-2xl bg-white border border-slate-100 hover:border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                    <div>
                        <!-- Icon Circle -->
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <x-icon :name="$service->icon" class="w-6 h-6" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $service->title }}
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed mb-6">
                            {{ $service->short_description }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100/80 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-400 group-hover:text-blue-600 transition">Learn More</span>
                        <a href="{{ route('services.show', $service->slug) }}" 
                           class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-blue-600 text-slate-400 group-hover:text-white flex items-center justify-center transition"
                           aria-label="View {{ $service->title }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. OUR PORTFOLIO SECTION -->
    <section class="py-20 bg-slate-50/60 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-2">Our Portfolio</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        A glimpse of our recent projects
                    </h2>
                </div>
                <a href="{{ route('portfolio.index') }}" 
                   class="mt-4 md:mt-0 inline-flex items-center text-sm font-semibold text-slate-700 hover:text-blue-600 group">
                    <span>View All Projects</span>
                    <svg class="w-4 h-4 ml-1.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($projects as $project)
                    <div class="group rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <!-- Project image / Mockup preview -->
                        <div class="relative h-48 bg-slate-900 overflow-hidden">
                            <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/90 backdrop-blur-md text-slate-800 shadow-sm">
                                    {{ $project->category }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex flex-col justify-between flex-grow">
                            <div>
                                <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $project->summary }}
                                </p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400 font-medium">Case Study</span>
                                <a href="{{ route('portfolio.show', $project->slug) }}" 
                                   class="text-slate-400 hover:text-blue-600 transition" 
                                   aria-label="View {{ $project->title }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. WHY CHOOSE US & KEY STATS -->
    <section class="py-20 lg:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Info -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-2">Why Choose Us</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        We combine creativity with technology
                    </h2>
                </div>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    We're not just developers, we're your technology partners. We architect solutions with uncompromising attention to clean code, performance, and long-term business scalability.
                </p>
                <div>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-slate-950 text-white font-semibold text-sm hover:bg-blue-600 transition shadow-sm group">
                        <span>Work With Us</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right 4 Stats Cards Grid -->
            <div class="lg:col-span-7">
                <div class="grid grid-cols-2 gap-4 sm:gap-6">
                    <!-- Stat 1: Happy Clients -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition text-center sm:text-left flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 mx-auto sm:mx-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 mb-1 tracking-tight">{{ $statClients }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500">Happy Clients</div>
                    </div>

                    <!-- Stat 2: Projects Completed -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition text-center sm:text-left flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 mx-auto sm:mx-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 mb-1 tracking-tight">{{ $statProjects }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500">Projects Completed</div>
                    </div>

                    <!-- Stat 3: Years Experience -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition text-center sm:text-left flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 mx-auto sm:mx-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 mb-1 tracking-tight">{{ $statYears }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500">Years Experience</div>
                    </div>

                    <!-- Stat 4: Client Satisfaction -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition text-center sm:text-left flex flex-col justify-between">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 mx-auto sm:mx-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m12 15-3-3m0 0 3-3m-3 3h12"/><path d="M4.5 16.5c-1.5 1.26-2 3.5-2 3.5s2.24-.5 3.5-2"/></svg>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-slate-900 mb-1 tracking-tight">{{ $statSat }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500">Client Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CLIENT TESTIMONIALS -->
    <section class="py-20 bg-slate-50/50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-2">Client Testimonials</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    What our clients say
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $testimonial)
                    <div class="p-7 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- 5 Stars -->
                            <div class="flex items-center gap-1 text-amber-400 mb-4">
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                    <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed italic mb-6">
                                "{{ $testimonial->content }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <img src="{{ $testimonial->avatar ?? '/assets/images/testimonials/avatar-1.jpg' }}" 
                                 alt="{{ $testimonial->client_name }}" 
                                 class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $testimonial->client_name }}</h4>
                                <p class="text-xs text-slate-400">{{ $testimonial->designation }}, {{ $testimonial->company }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Dots indicator -->
            <div class="flex items-center justify-center gap-1.5 mt-8">
                <span class="w-6 h-1.5 rounded-full bg-blue-600"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
            </div>
        </div>
    </section>

    <!-- 7. CALL TO ACTION BANNER -->
    <x-cta-banner />

    <!-- 8. LATEST INSIGHTS & BLOG UPDATES -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-2">From Our Blog</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Latest insights & updates
                </h2>
            </div>
            <a href="{{ route('blog.index') }}" 
               class="mt-4 md:mt-0 inline-flex items-center text-sm font-semibold text-slate-700 hover:text-blue-600 group">
                <span>View All Posts</span>
                <svg class="w-4 h-4 ml-1.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentBlogs as $blog)
                <div class="group rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div class="h-44 bg-slate-900 relative overflow-hidden">
                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/90 backdrop-blur-md text-blue-600">
                                {{ $blog->category }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            <span class="text-[11px] text-slate-400 font-medium block mb-2">
                                {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Recent' }} • {{ $blog->read_time }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">
                                {{ $blog->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $blog->excerpt }}
                            </p>
                        </div>

                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 group/btn">
                                <span>Read More</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

