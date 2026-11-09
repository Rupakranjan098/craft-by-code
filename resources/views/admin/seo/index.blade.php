@extends('layouts.admin')

@section('title', 'Manage SEO & Meta Tags')
@section('header_title', 'SEO Management')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">SEO & Metadata Configuration</h1>
            <p class="text-xs text-slate-500">Configure search engine titles, default descriptions, and social sharing metadata for Google, Bing, and OpenGraph</p>
        </div>

        <form action="{{ route('admin.seo.update') }}" method="POST" class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf

            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900">Global Search Meta Tags</h2>
                <p class="text-xs text-slate-400">These values serve as global fallbacks when page-specific SEO is not defined</p>
            </div>

            <div class="space-y-5">
                @foreach($settings as $setting)
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ $setting->label ?? ucwords(str_replace('_', ' ', $setting->key)) }}
                        </label>
                        @if($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" rows="3" 
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old($setting->key, $setting->value) }}</textarea>
                        @else
                            <input type="text" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                    Save SEO Settings
                </button>
            </div>
        </form>
    </div>
@endsection

