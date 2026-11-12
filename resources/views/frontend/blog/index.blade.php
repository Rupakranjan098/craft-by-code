@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'Insights & Engineering Blog | ' . $brandName)
@section('meta_description', 'Technical guides on MVP architecture, SaaS scalability, DevOps & Cloud automation, UI/UX engineering, and AI workflows for global startups by ' . $brandName . '.')
@section('canonical', route('blog.index'))
@if(request()->filled('search') || request()->filled('category'))
@section('meta_robots', 'noindex, follow')
@endif

@section('content')
    <section class="py-14 sm:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-3">Knowledge Base</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-5">
                Latest Insights &amp; <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Updates</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
                Practical guides, deep-dives into software architecture, design principles, and engineering methodologies.
            </p>

            <form action="{{ route('blog.index') }}" method="GET" class="max-w-md mx-auto relative mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                       class="w-full pl-11 pr-24 py-3 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-sm">
                <div class="absolute left-4 top-3.5 text-slate-400">
                    <x-icon name="search" class="w-4 h-4" />
                </div>
                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-slate-900 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-500 text-white text-xs font-bold rounded-full transition">
                    Search
                </button>
            </form>

            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('blog.index') }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('category') ? 'bg-slate-900 dark:bg-blue-600 text-white shadow' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    All Topics
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('category') === $cat ? 'bg-slate-900 dark:bg-blue-600 text-white shadow' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->isEmpty())
            <div class="text-center py-16">
                <p class="text-slate-500 dark:text-slate-400 mb-4">No articles found.</p>
                <a href="{{ route('blog.index') }}" class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline">View all articles</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($posts as $post)
                    <div class="group rounded-3xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl dark:hover:shadow-blue-950/40 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                        <div class="h-48 bg-slate-900 relative overflow-hidden">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-blue-600 dark:text-blue-400 shadow border border-white/20 dark:border-slate-700">
                                    {{ $post->category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium block mb-2">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }} • {{ $post->read_time }}
                                </span>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">By {{ $post->author_name }}</span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1 group/btn">
                                    <span>Read More</span>
                                    <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

    <x-cta-banner />
@endsection
