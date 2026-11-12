@extends('layouts.admin')

@section('title', $service->exists ? 'Edit Service: ' . $service->title : 'Create New Service')
@section('header_title', $service->exists ? 'Edit Service' : 'Add New Service')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Services List</span>
            </a>
            @if($service->exists)
                <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                    View on Website &rarr;
                </a>
            @endif
        </div>

        <form action="{{ $service->exists ? route('admin.services.update', $service->id) : route('admin.services.store') }}" 
              method="POST" 
              class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf
            @if($service->exists)
                @method('PUT')
            @endif

            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
                {{ $service->exists ? 'Update Service Details' : 'Create New Service' }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Service Title *</label>
                    <input type="text" name="title" required value="{{ old('title', $service->title) }}" placeholder="e.g. Web Development"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Slug (leave blank to auto-generate)</label>
                    <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="web-development"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Icon -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Icon *</label>
                    <select name="icon" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @php
                            $availableIcons = ['code', 'globe', 'smartphone', 'palette', 'cpu', 'git-merge', 'briefcase', 'shopping-cart', 'shield-check', 'layers', 'cloud', 'browser'];
                        @endphp
                        @foreach($availableIcons as $ic)
                            <option value="{{ $ic }}" {{ old('icon', $service->icon) === $ic ? 'selected' : '' }}>{{ ucfirst($ic) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Badge -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge (Optional)</label>
                    <input type="text" name="badge" value="{{ old('badge', $service->badge) }}" placeholder="e.g. Popular, Core"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Order -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Display Order</label>
                    <input type="number" name="order" value="{{ old('order', $service->order ?? 0) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Short Description -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Description (for cards) *</label>
                <textarea name="short_description" required rows="2" placeholder="Brief summary of the service..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('short_description', $service->short_description) }}</textarea>
            </div>

            <!-- Full Description -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Description (for detail page) *</label>
                <textarea name="full_description" required rows="6" placeholder="In-depth explanation of our engineering methodology and deliverables..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('full_description', $service->full_description) }}</textarea>
            </div>

            <!-- Features & Benefits -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Key Features (one per line)</label>
                    <textarea name="features" rows="5" placeholder="Single Page Applications (SPA)&#10;Progressive Web Apps (PWA)&#10;Custom Backend API"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('features', is_array($service->features) ? implode("\n", $service->features) : '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Business Benefits (one per line)</label>
                    <textarea name="benefits" rows="5" placeholder="Sub-second response times&#10;Clean and scalable code architecture&#10;Zero vendor lock-in"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('benefits', is_array($service->benefits) ? implode("\n", $service->benefits) : '') }}</textarea>
                </div>
            </div>

            <!-- Tech Stack -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Technologies Used (comma separated)</label>
                <input type="text" name="tech_stack" value="{{ old('tech_stack', is_array($service->tech_stack) ? implode(", ", $service->tech_stack) : '') }}" placeholder="Laravel, PHP 8.4, Vue.js, Tailwind CSS, MySQL"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Status Checkboxes -->
            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Display in Featured Hero Row</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Active (Publicly Visible)</span>
                </label>
            </div>

            <!-- SEO -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="text-sm font-bold text-slate-900">SEO Settings for This Service</h3>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}" placeholder="Custom Web Development Services | CraftByCode"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description', $service->meta_description) }}" placeholder="We build high-performance web applications..."
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow">
                    {{ $service->exists ? 'Save Changes' : 'Create Service' }}
                </button>
            </div>
        </form>
    </div>
@endsection

