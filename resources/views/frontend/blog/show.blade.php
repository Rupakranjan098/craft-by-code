@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', $post->title . ' | ' . $brandName . ' Blog')
@section('meta_description', $post->excerpt)

@section('content')
    <article class="py-16 lg:py-20 gradient-hero border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Blog</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold truncate">{{ $post->title }}</span>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 inline-block mb-4">
                {{ $post->category }}
            </span>

            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>

            <div class="flex items-center gap-4 text-xs text-slate-500 pb-2">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center">
                    UP
                </div>
                <div>
                    <span class="font-bold text-slate-900 block">{{ $post->author_name }}</span>
                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }} • {{ $post->read_time }}</span>
                </div>
            </div>
        </div>
    </article>

    <!-- Main Content -->
    <div class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl overflow-hidden shadow-xl mb-12 bg-slate-900">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-auto object-cover max-h-[480px]">
        </div>

        <div class="prose prose-lg prose-slate max-w-none leading-relaxed text-slate-700 space-y-6">
            <p class="text-xl font-medium text-slate-800 leading-relaxed border-l-4 border-blue-600 pl-4 py-1 italic bg-blue-50/30 rounded-r-xl">
                {{ $post->excerpt }}
            </p>

            <div class="content space-y-4 pt-4">
                {!! $post->content !!}
            </div>
        </div>

        <!-- Author Footer Card -->
        <div class="mt-16 p-8 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-blue-600 to-purple-600 text-white font-bold text-xl flex items-center justify-center flex-shrink-0 shadow">
                UP
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 mb-1">{{ $post->author_name }}</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Senior engineering contributor at {{ $brandName }}. Focused on building fault-tolerant backend architectures, performant user interfaces, and automated AI pipelines.
                </p>
            </div>
        </div>

        <!-- Related Posts -->
        @if($recentPosts->isNotEmpty())
            <div class="mt-20 pt-12 border-t border-slate-100">
                <h3 class="text-2xl font-bold text-slate-900 mb-8">Related Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($recentPosts as $rec)
                        <a href="{{ route('blog.show', $rec->slug) }}" class="group block rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="h-32 bg-slate-900 overflow-hidden">
                                <img src="{{ $rec->image }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4">
                                <span class="text-[11px] font-semibold text-blue-600 block mb-1">{{ $rec->category }}</span>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">{{ $rec->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-cta-banner />
@endsection

