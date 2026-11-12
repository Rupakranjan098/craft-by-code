@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'Services | ' . $brandName . ' - Custom Software, SaaS, DevOps & AI')
@section('meta_description', 'Explore ' . $brandName . ' full suite of software development services: Custom Software, Web Apps, Mobile Apps, SaaS Platforms, DevOps & Cloud, AI Automation, UI/UX, and E-commerce.')

@section('content')
    <!-- Services Hero -->
    <section class="py-14 sm:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-3">Our Core Capabilities</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-5">
                Comprehensive <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Digital Services</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
                From initial concept and architectural prototyping to enterprise cloud deployment, we deliver high-impact software solutions engineered for scalability.
            </p>

            <!-- Search form -->
            <form action="{{ route('services.index') }}" method="GET" class="max-w-md mx-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services (e.g., SaaS, DevOps, AI, Mobile)..."
                       class="w-full pl-11 pr-24 py-3 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-sm">
                <div class="absolute left-4 top-3.5 text-slate-400">
                    <x-icon name="search" class="w-4 h-4" />
                </div>
                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-slate-900 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-500 text-white text-xs font-bold rounded-full transition">
                    Search
                </button>
            </form>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($services->isEmpty())
            <div class="text-center py-16">
                <p class="text-slate-500 dark:text-slate-400 mb-4">No services matched your query.</p>
                <a href="{{ route('services.index') }}" class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline">Reset search</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($services as $service)
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-700 shadow-sm hover:shadow-xl dark:hover:shadow-blue-950/40 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                        <div>
                            <div class="flex items-center justify-between mb-6 gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                    <x-icon :name="$service->icon" class="w-7 h-7" />
                                </div>
                                @if($service->badge)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/80">
                                        {{ $service->badge }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                                {{ $service->title }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                                {{ $service->short_description }}
                            </p>

                            <!-- Features List Preview -->
                            @if(!empty($service->features))
                                <ul class="space-y-2 mb-6">
                                    @foreach(array_slice($service->features, 0, 3) as $feat)
                                        <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                                                <x-icon name="check" class="w-3 h-3" />
                                            </div>
                                            <span>{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="pt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Full Details &amp; Stack</span>
                            <a href="{{ route('services.show', $service->slug) }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition group">
                                <span>Explore Service</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $services->links() }}
            </div>
        @endif
    </section>

    <!-- CTA Banner -->
    <x-cta-banner />
@endsection
