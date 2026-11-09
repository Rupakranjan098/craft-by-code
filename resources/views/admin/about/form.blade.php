@extends('layouts.admin')

@section('title', 'Edit About Section: ' . $about->title)
@section('header_title', 'Edit About Us Section')

@section('content')
    <div class="max-w-4xl space-y-6">
        <a href="{{ route('admin.about.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to About Sections</span>
        </a>

        <form action="{{ route('admin.about.update', $about->id) }}" method="POST" class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-blue-600 font-mono block">Section: {{ $about->section_key }}</span>
                    <h2 class="text-xl font-bold text-slate-900 mt-0.5">Edit Section Content</h2>
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $about->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Active</span>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Section Headline *</label>
                    <input type="text" name="title" required value="{{ old('title', $about->title) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle / Overline</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Main Paragraph Content</label>
                <textarea name="content" rows="5" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('content', $about->content) }}</textarea>
            </div>

            @if($about->data !== null)
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Structured Data (JSON)</label>
                    <textarea name="data_json" rows="8" font-mono class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('data_json', json_encode($about->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Configures arrays of steps, values, or team members.</p>
                </div>
            @endif

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.about.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection

