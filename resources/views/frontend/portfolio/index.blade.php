@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'Portfolio & Case Studies | ' . $brandName . ' - Startup Work')
@section('meta_description', 'Explore ' . $brandName . ' portfolio of MVPs, SaaS platforms, web applications, mobile apps, and cloud engineering built for global startups.')
@section('canonical', route('portfolio.index'))
@if(request()->filled('category'))
@section('meta_robots', 'noindex, follow')
@endif

@section('content')
    <section class="py-14 sm:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-3">Our Work</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-5">
                Featured <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Projects &amp; Portfolio</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
                A selection of high-performance digital products, SaaS applications, and mobile platforms we have architected and deployed.
            </p>

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('portfolio.index') }}" 
                   class="px-4 py-2 rounded-full text-xs font-semibold transition {{ empty($category) || $category === 'all' ? 'bg-slate-900 dark:bg-blue-600 text-white shadow' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    All Projects
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('portfolio.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-full text-xs font-semibold transition {{ $category === $cat ? 'bg-slate-900 dark:bg-blue-600 text-white shadow' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->isEmpty())
            <div class="text-center py-16">
                <p class="text-slate-500 dark:text-slate-400 mb-4">No projects found in this category.</p>
                <a href="{{ route('portfolio.index') }}" class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline">View all projects</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($projects as $project)
                    <div class="group rounded-3xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl dark:hover:shadow-blue-950/40 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                        <div class="h-56 bg-slate-900 relative overflow-hidden">
                            <img src="{{ $project->image }}" alt="{{ $project->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-900 dark:text-white shadow border border-white/20 dark:border-slate-700">
                                    {{ $project->category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                    {{ $project->summary }}
                                </p>

                                @if(!empty($project->technologies))
                                    <div class="flex flex-wrap gap-1.5 mb-6">
                                        @foreach(array_slice($project->technologies, 0, 4) as $t)
                                            <span class="px-2 py-0.5 rounded-md bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-[11px] font-medium text-slate-600 dark:text-slate-300">
                                                {{ $t }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">View Case Study</span>
                                <a href="{{ route('portfolio.show', $project->slug) }}" 
                                   class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-blue-600 text-slate-400 group-hover:text-white flex items-center justify-center transition"
                                   aria-label="View {{ $project->title }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @endif
    </section>

    <x-cta-banner />
@endsection
