@extends('layouts.admin')

@section('title', 'Manage SEO & Meta Tags')
@section('header_title', 'SEO Management')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">SEO, Search Console &amp; Analytics</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Configure default search metadata, Open Graph sharing image, Google Search Console ownership verification, and Google Analytics 4.</p>
            </div>
            <a href="{{ route('sitemap') }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition whitespace-nowrap">
                View XML Sitemap
            </a>
        </div>

        <form action="{{ route('admin.seo.update') }}" method="POST" class="bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
            @csrf

            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Global Search, Verification &amp; Tracking</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500">Global fallbacks and optional Google integrations rendered automatically across public pages.</p>
            </div>

            <div class="space-y-5">
                @foreach($settings as $setting)
                    <div>
                        <label for="seo-{{ $setting->key }}" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            {{ $setting->label ?? ucwords(str_replace('_', ' ', $setting->key)) }}
                        </label>
                        @if($setting->type === 'textarea')
                            <textarea id="seo-{{ $setting->key }}" name="{{ $setting->key }}" rows="3"
                                      class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old($setting->key, $setting->value) }}</textarea>
                        @else
                            <input id="seo-{{ $setting->key }}" type="text" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @endif
                        @error($setting->key)
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                    Save SEO Settings
                </button>
            </div>
        </form>
    </div>
@endsection
