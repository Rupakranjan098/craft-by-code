@extends('layouts.admin')

@section('title', 'Manage About Us Content')
@section('header_title', 'About Us Management')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">About Us Page Sections</h1>
                <p class="text-xs text-slate-500">Edit company story, mission, vision, core values, 5-step development methodology, and leadership team</p>
            </div>
            <a href="{{ route('about') }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1.5">
                <x-icon name="eye" class="w-3.5 h-3.5" />
                <span>View About Page</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($sections as $sec)
                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:border-blue-200 transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 font-mono">
                                #{{ $sec->section_key }}
                            </span>
                            @if($sec->is_active)
                                <span class="text-[10px] font-bold text-emerald-600">Active</span>
                            @else
                                <span class="text-[10px] font-bold text-slate-400">Inactive</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $sec->title }}</h3>
                        @if($sec->subtitle)
                            <div class="text-xs text-blue-600 font-semibold mb-3">{{ $sec->subtitle }}</div>
                        @endif
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                            {{ $sec->content ?? 'Structured JSON content (steps, values, or team members)' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">Order: {{ $sec->order }}</span>
                        <a href="{{ route('admin.about.edit', $sec->id) }}" 
                           class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-700">
                            <span>Edit Section</span>
                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

