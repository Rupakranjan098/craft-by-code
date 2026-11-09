@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')
@section('header_title', $testimonial->exists ? 'Edit Testimonial' : 'New Testimonial')

@section('content')
    <div class="max-w-3xl space-y-6">
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Testimonials</span>
        </a>

        <form action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf
            @if($testimonial->exists)
                @method('PUT')
            @endif

            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
                {{ $testimonial->exists ? 'Edit Testimonial' : 'Create New Testimonial' }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Client Full Name *</label>
                    <input type="text" name="client_name" required value="{{ old('client_name', $testimonial->client_name) }}" placeholder="e.g. Rohit Sharma"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Designation / Role *</label>
                    <input type="text" name="designation" required value="{{ old('designation', $testimonial->designation) }}" placeholder="e.g. CEO & Co-Founder"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Company Name *</label>
                    <input type="text" name="company" required value="{{ old('company', $testimonial->company) }}" placeholder="e.g. D2C Startup"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Rating (Stars) *</label>
                    <select name="rating" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="5" {{ old('rating', $testimonial->rating ?? 5) == 5 ? 'selected' : '' }}>5 Stars - Excellent</option>
                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Stars - Very Good</option>
                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Stars - Good</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Client Avatar / Photo</label>
                <div class="flex items-center gap-4">
                    @if($testimonial->avatar)
                        <img src="{{ $testimonial->avatar }}" alt="" class="w-12 h-12 rounded-full object-cover">
                    @endif
                    <input type="file" name="avatar_file" accept="image/*" class="text-xs text-slate-500 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Client Feedback / Testimonial *</label>
                <textarea name="content" required rows="4" placeholder="UpPage Technology delivered top notch code on time..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('content', $testimonial->content) }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Display in Homepage Testimonials Slider</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-700">Active</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow">
                    {{ $testimonial->exists ? 'Update Testimonial' : 'Save Testimonial' }}
                </button>
            </div>
        </form>
    </div>
@endsection

