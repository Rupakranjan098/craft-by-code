@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', $solution->title . ' | ' . $brandName . ' Digital Solutions')
@section('meta_description', $solution->short_description)

@section('content')
    <section class="py-16 lg:py-20 gradient-hero border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('solutions.index') }}" class="hover:text-blue-600 transition">Digital Solutions</a>
                <span>/</span>
                <span class="text-slate-900 font-semibold">{{ $solution->title }}</span>
            </div>

            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                        <x-icon :name="$solution->icon" class="w-7 h-7" />
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $solution->category ?? 'Enterprise Solution' }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight mt-1">
                            {{ $solution->title }}
                        </h1>
                    </div>
                </div>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    {{ $solution->short_description }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 space-y-10">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-4">Solution Deep-Dive</h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        {{ $solution->full_description }}
                    </p>
                </div>

                @if(!empty($solution->features))
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Core Architectural Features</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($solution->features as $feat)
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <x-icon name="check" class="w-3.5 h-3.5" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!empty($solution->benefits))
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Enterprise Benefits</h3>
                        <div class="space-y-3">
                            @foreach($solution->benefits as $ben)
                                <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100/60 flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <x-icon name="sparkles" class="w-3 h-3" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-800">{{ $ben }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!empty($solution->technologies))
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Technology Stack</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($solution->technologies as $tech)
                                <span class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4">
                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">Deploy This Solution</h3>
                        <p class="text-xs text-slate-500">Need a tailored implementation of {{ $solution->title }}? Schedule a discovery sprint with our engineering team.</p>
                    </div>

                    <a href="{{ route('contact', ['subject' => 'Inquiry for ' . $solution->title, 'service_interested' => $solution->title]) }}" 
                       class="block w-full py-3.5 px-4 text-center rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Schedule Discovery Call
                    </a>

                    <div class="pt-6 border-t border-slate-200">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Other Digital Solutions</h4>
                        <ul class="space-y-2 text-xs">
                            @foreach($allSolutions->take(5) as $other)
                                <li>
                                    <a href="{{ route('solutions.show', $other->slug) }}" class="text-slate-600 hover:text-blue-600 transition flex items-center justify-between py-1">
                                        <span>{{ $other->title }}</span>
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-cta-banner />
@endsection

