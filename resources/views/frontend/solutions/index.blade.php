@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'Digital Solutions | ' . $brandName . ' - Enterprise & Cloud Platforms')
@section('meta_description', 'Explore ' . $brandName . ' end-to-end digital solutions: Enterprise Platforms, Business Automation, AI Agents, Cloud Infrastructure, and System Integration.')

@section('content')
    <!-- Hero Header -->
    <section class="py-20 gradient-hero border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-3">Enterprise Capabilities</span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-5">
                Scalable <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Digital Solutions</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Empowering businesses with modern digital architecture, intelligent automation, and robust enterprise platforms designed for high velocity.
            </p>
        </div>
    </section>

    <!-- Solutions List -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-12">
            @foreach($solutions as $index => $sol)
                <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-8 space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <x-icon :name="$sol->icon" class="w-6 h-6" />
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $sol->category ?? 'Enterprise' }}</span>
                                    <h3 class="text-2xl font-bold text-slate-900">{{ $sol->title }}</h3>
                                </div>
                            </div>

                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                                {{ $sol->full_description }}
                            </p>

                            @if(!empty($sol->features))
                                <div class="pt-2">
                                    <div class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">Core Features:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($sol->features as $feat)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-50 border border-slate-200/70 text-xs font-medium text-slate-700">
                                                <x-icon name="check" class="w-3 h-3 text-emerald-600" />
                                                <span>{{ $feat }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(!empty($sol->technologies))
                                <div class="flex flex-wrap items-center gap-1.5 pt-2">
                                    <span class="text-xs font-bold text-slate-400 mr-2">Technologies:</span>
                                    @foreach($sol->technologies as $tech)
                                        <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[11px] font-semibold">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-4 flex flex-col justify-center items-start lg:items-end gap-3 pt-4 lg:pt-0 lg:border-l border-slate-100 lg:pl-8">
                            <a href="{{ route('solutions.show', $sol->slug) }}" 
                               class="w-full sm:w-auto text-center px-6 py-3 rounded-full bg-slate-900 text-white font-semibold text-xs hover:bg-blue-600 transition shadow">
                                View Architecture
                            </a>
                            <a href="{{ route('contact', ['subject' => 'Inquiry for ' . $sol->title]) }}" 
                               class="w-full sm:w-auto text-center px-6 py-3 rounded-full bg-slate-50 border border-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-100 transition">
                                Request Proposal
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- CTA Banner -->
    <x-cta-banner />
@endsection

