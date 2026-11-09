@extends('layouts.admin')

@section('title', $solution->exists ? 'Edit Solution: ' . $solution->title : 'Add Digital Solution')
@section('header_title', $solution->exists ? 'Edit Solution' : 'New Digital Solution')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.solutions.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Solutions</span>
            </a>
            @if($solution->exists)
                <a href="{{ route('solutions.show', $solution->slug) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                    View on Website &rarr;
                </a>
            @endif
        </div>

        <form action="{{ $solution->exists ? route('admin.solutions.update', $solution->id) : route('admin.solutions.store') }}" 
              method="POST" 
              class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf
            @if($solution->exists)
                @method('PUT')
            @endif

            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
                {{ $solution->exists ? 'Edit Solution Details' : 'Create Digital Solution' }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Solution Title *</label>
                    <input type="text" name="title" required value="{{ old('title', $solution->title) }}" placeholder="e.g. Enterprise Software Solutions"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $solution->slug) }}" placeholder="enterprise-software-solutions"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category', $solution->category) }}" placeholder="e.g. Enterprise, AI, Cloud"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Icon</label>
                    <select name="icon" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @php
                            $availableIcons = ['layers', 'building', 'workflow', 'cpu', 'browser', 'smartphone', 'cloud', 'shield', 'share-2', 'code'];
                        @endphp
                        @foreach($availableIcons as $ic)
                            <option value="{{ $ic }}" {{ old('icon', $solution->icon) === $ic ? 'selected' : '' }}>{{ ucfirst($ic) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Display Order</label>
                    <input type="number" name="order" value="{{ old('order', $solution->order ?? 0) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Description *</label>
                <textarea name="short_description" required rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('short_description', $solution->short_description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Description *</label>
                <textarea name="full_description" required rows="5" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('full_description', $solution->full_description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Features (one per line)</label>
                    <textarea name="features" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('features', is_array($solution->features) ? implode("\n", $solution->features) : '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Benefits (one per line)</label>
                    <textarea name="benefits" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('benefits', is_array($solution->benefits) ? implode("\n", $solution->benefits) : '') }}</textarea>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Technologies (comma separated)</label>
                <input type="text" name="technologies" value="{{ old('technologies', is_array($solution->technologies) ? implode(", ", $solution->technologies) : '') }}" placeholder="Laravel, Docker, Redis, Kubernetes"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $solution->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Active (Visible on public site)</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.solutions.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow">
                    {{ $solution->exists ? 'Update Solution' : 'Save Solution' }}
                </button>
            </div>
        </form>
    </div>
@endsection

