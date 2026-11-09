@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'Insights & Updates | ' . $brandName . ' Blog')
@section('meta_description', 'Latest technical insights, clean code architecture, UI/UX design trends, and AI automation guides by ' . $brandName . '.')

@section('content')
    <section class="py-20 gradient-hero border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-3">Knowledge Base</span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-5">
                Latest Insights & <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Updates</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                Practical guides, deep-dives into software architecture, design principles, and engineering methodologies.
            </p>

            <form action="{{ route('blog.index') }}" method="GET" class="max-w-md mx-auto relative mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                       class="w-full pl-11 pr-24 py-3 rounded-full bg-white border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-sm">
                <div class="absolute left-4 top-3.5 text-slate-400">
                    <x-icon name="search" class="w-4 h-4" />
                </div>
                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold rounded-full transition">
                    Search
                </button>
            </form>

            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('blog.index') }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('category') ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    All Topics
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('category') === $cat ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->isEmpty())
            <div class="text-center py-16">
                <p class="text-slate-500 mb-4">No articles found.</p>
                <a href="{{ route('blog.index') }}" class="text-blue-600 font-semibold text-sm hover:underline">View all articles</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <div class="group rounded-3xl bg-white border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                        <div class="h-48 bg-slate-900 relative overflow-hidden">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-md text-blue-600 shadow">
                                    {{ $post->category }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-xs text-slate-400 font-medium block mb-2">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }} • {{ $post->read_time }}
                                </span>
                                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-medium">By {{ $post->author_name }}</span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 group/btn">
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

