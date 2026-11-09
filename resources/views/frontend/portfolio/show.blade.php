@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', $project->title . ' Case Study | ' . $brandName . ' Portfolio')
@section('meta_description', $project->summary)

@section('content')
    <section class="py-16 lg:py-20 gradient-hero border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('portfolio.index') }}" class="hover:text-blue-600 transition">Portfolio</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">{{ $project->title }}</span>
            </div>

            <div class="max-w-4xl">
                <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 inline-block mb-3">
                    {{ $project->category }}
                </span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                    {{ $project->title }}
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed mb-6">
                    {{ $project->summary }}
                </p>

                <div class="flex flex-wrap items-center gap-6 text-xs text-slate-500 pt-2 border-t border-slate-200/60">
                    @if($project->client_name)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Client</span>
                            <span class="font-bold text-slate-800">{{ $project->client_name }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-slate-400 block mb-0.5">Category</span>
                        <span class="font-bold text-slate-800">{{ $project->category }}</span>
                    </div>
                    @if($project->project_url)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Live Demo</span>
                            <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="font-bold text-blue-600 hover:underline flex items-center gap-1">
                                <span>Visit Platform</span>
                                <x-icon name="arrow-up-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Case Study Content -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-12 max-w-4xl mx-auto">
            <!-- Full Project Preview Image -->
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-100 bg-slate-950">
                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-auto object-cover">
            </div>

            <!-- Description -->
            @if($project->description)
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-slate-900">Project Overview</h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        {{ $project->description }}
                    </p>
                </div>
            @endif

            <!-- Challenge & Solution Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if($project->challenge)
                    <div class="p-8 rounded-2xl bg-rose-50/50 border border-rose-100/80">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">The Challenge</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $project->challenge }}</p>
                    </div>
                @endif

                @if($project->solution)
                    <div class="p-8 rounded-2xl bg-blue-50/50 border border-blue-100/80">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Our Solution</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $project->solution }}</p>
                    </div>
                @endif
            </div>

            <!-- Measurable Results -->
            @if($project->results)
                <div class="p-8 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center">
                            <x-icon name="sparkles" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Key Outcomes & Measurable Results</h3>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $project->results }}</p>
                </div>
            @endif

            <!-- Technologies -->
            @if(!empty($project->technologies))
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3">Technologies Leveraged</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $t)
                            <span class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
                                {{ $t }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <x-cta-banner />
@endsection

