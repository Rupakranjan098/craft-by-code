@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', ($service->meta_title ?? $service->title . ' Services') . ' | ' . $brandName)
@section('meta_description', $service->meta_description ?? $service->short_description)

@section('content')
    <!-- Service Header -->
    <section class="py-12 sm:py-16 lg:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400 mb-5 sm:mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a>
                <span>/</span>
                <a href="{{ route('services.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Services</a>
                <span>/</span>
                <span class="text-slate-900 dark:text-white font-semibold">{{ $service->title }}</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="flex items-start sm:items-center gap-4 mb-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md flex-shrink-0">
                            <x-icon :name="$service->icon" class="w-6 h-6 sm:w-7 sm:h-7" />
                        </div>
                        <div class="min-w-0">
                            @if($service->badge)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/80 inline-block mb-1">
                                    {{ $service->badge }}
                                </span>
                            @endif
                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight mt-1">
                                {{ $service->title }}
                            </h1>
                        </div>
                    </div>
                    <p class="text-sm sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                        {{ $service->short_description }}
                    </p>
                </div>

                <div class="w-full md:w-auto flex-shrink-0">
                    <a href="#inquire-form" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-slate-900 dark:bg-blue-600 text-white font-semibold text-sm hover:bg-blue-600 dark:hover:bg-blue-500 transition shadow hover:shadow-md">
                        <span>Inquire About This Service</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Service Content Grid -->
    <section class="py-12 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
            <!-- Left 8 cols: Detailed Overview, Features, Benefits, Tech Stack -->
            <div class="lg:col-span-8 space-y-10 sm:space-y-12">
                <!-- Overview -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white mb-4">Service Overview</h2>
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed space-y-4">
                        <p class="text-sm sm:text-lg">
                            {{ $service->full_description }}
                        </p>
                    </div>
                </div>

                <!-- Key Features -->
                @if(!empty($service->features))
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-5 sm:mb-6">Key Capabilities & Features</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($service->features as $feat)
                                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <x-icon name="check" class="w-3.5 h-3.5" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Business Benefits -->
                @if(!empty($service->benefits))
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-5 sm:mb-6">Business Benefits</h3>
                        <div class="space-y-3">
                            @foreach($service->benefits as $ben)
                                <div class="p-4 rounded-xl bg-blue-50/50 dark:bg-blue-950/30 border border-blue-100/60 dark:border-blue-900/60 flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <x-icon name="sparkles" class="w-3 h-3" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $ben }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Technologies Used -->
                @if(!empty($service->tech_stack))
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-4">Technologies & Frameworks We Use</h3>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($service->tech_stack as $tech)
                                <span class="px-4 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Case Studies / Projects -->
                @if($relatedProjects->isNotEmpty())
                    <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-6">Related Projects</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($relatedProjects as $proj)
                                <a href="{{ route('portfolio.show', $proj->slug) }}" class="group block rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition">
                                    <div class="h-40 bg-slate-900 overflow-hidden">
                                        <img src="{{ $proj->image }}" alt="{{ $proj->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    </div>
                                    <div class="p-4">
                                        <span class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 block mb-1">{{ $proj->category }}</span>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $proj->title }}</h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right 4 cols: Sticky Quick Inquiry Box -->
            <div class="lg:col-span-4">
                <div id="inquire-form" class="sticky top-28 p-5 sm:p-7 rounded-3xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200/80 dark:border-slate-800 shadow-md">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Inquire About {{ $service->title }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Fill in your requirements and our solutions architect will reach out within 24 hours.</p>

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service_interested" value="{{ $service->title }}">
                        <input type="hidden" name="subject" value="Inquiry for {{ $service->title }}">

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Your Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Alex Morgan"
                                   class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Work Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="alex@company.com"
                                   class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000"
                                   class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Project Details *</label>
                            <textarea name="message" required rows="4" placeholder="Briefly describe your objectives, timeline, or current challenges..."
                                      class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs tracking-wide uppercase transition shadow-md">
                            Submit Inquiry
                        </button>
                    </form>

                    @php($directEmail = \App\Models\WebsiteSetting::get('contact_email', 'hello@craftbycode.tech'))
                    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800 text-center">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">Prefer direct email?</p>
                        <a href="mailto:{{ $directEmail }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline break-all">{{ $directEmail }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <x-cta-banner />
@endsection

