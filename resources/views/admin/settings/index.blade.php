@extends('layouts.admin')

@section('title', 'Manage Website Content & Settings')
@section('header_title', 'Website Content & Branding Engine')

@section('content')
<div class="space-y-6 max-w-5xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Website Content & Branding Engine</h1>
            <p class="text-xs text-slate-500">Configure logo assets, typography, headlines, statistics, contact details, and marketing banners in real time</p>
        </div>
        @if($group === 'general')
            <form action="{{ route('admin.settings.reset-logo') }}" method="POST" 
                  onsubmit="return confirm('Restore the logo and brand identity to system defaults?');">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold text-xs transition border border-slate-200">
                    Reset Brand to Defaults
                </button>
            </form>
        @endif
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        @php
            $tabLabels = [
                'general' => 'Logo & Brand Identity',
                'hero' => 'Hero Section',
                'stats' => 'Company Statistics',
                'contact' => 'Company Contact Info',
                'social' => 'Social Media Links',
                'cta' => 'Call To Action Banner',
            ];
        @endphp
        @foreach($allGroups as $g)
            <a href="{{ route('admin.settings.index', ['group' => $g]) }}" 
               class="px-4 py-2.5 rounded-xl text-xs font-bold transition {{ $group === $g ? 'bg-blue-600 text-white shadow' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                {{ $tabLabels[$g] ?? ucfirst($g) }}
            </a>
        @endforeach
    </div>

    <!-- Main Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" 
          class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-8">
        @csrf
        <input type="hidden" name="group" value="{{ $group }}">

        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $tabLabels[$group] ?? ucfirst($group) }}
                </h2>
                <p class="text-xs text-slate-400">Updates saved here immediately propagate across all pages</p>
            </div>
            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                Live Dynamic Sync
            </span>
        </div>

        @if($group === 'general')
            <!-- 1. BRANDING & LOGO MODULE -->
            <div class="space-y-8">
                <!-- Live Visual Previews -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Live Logo Preview</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Light Header / Navbar</span>
                            <div class="py-3 flex items-center justify-center bg-slate-50/50 rounded-xl min-h-[70px]">
                                <x-logo size="md" />
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 text-center">Used on light public pages</span>
                        </div>

                        <div class="p-5 rounded-2xl bg-[#080D19] border border-slate-800 shadow-sm flex flex-col justify-between text-white">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Dark Sidebar & Login</span>
                            <div class="py-3 flex items-center justify-center bg-white/5 rounded-xl min-h-[70px]">
                                <x-logo size="md" dark="true" />
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 text-center">Used in Admin & Dark Areas</span>
                        </div>

                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Icon / Favicon</span>
                            <div class="py-3 flex items-center justify-center bg-slate-50/50 rounded-xl min-h-[70px]">
                                <x-logo size="lg" :onlyIcon="true" />
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 text-center">Browser tabs & App bookmarks</span>
                        </div>
                    </div>
                </div>

                <!-- Logo Upload Inputs -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Upload Custom Logo Files</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Primary Website Logo (Light Background)</label>
                            <input type="file" name="site_logo_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo']->value ?? '/assets/images/logo-horizontal.png' }}</span></p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Dark Mode Logo (Dark Sidebar & Login)</label>
                            <input type="file" name="site_logo_dark_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo_dark']->value ?? '/assets/images/logo-horizontal-dark.png' }}</span></p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Logo Icon / Favicon (Square/Hexagon PNG)</label>
                            <input type="file" name="site_logo_icon_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo_icon']->value ?? '/assets/images/logo-icon-transparent.png' }}</span></p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Full Graphic Logo (High-Res 1024x1024 Badge)</label>
                            <input type="file" name="site_logo_full_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-500 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo_full']->value ?? '/assets/images/logo.png' }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Brand Typography & Text Settings -->
                <div class="pt-6 border-t border-slate-100 space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Brand Typography & Taglines</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Company Brand Name
                            </label>
                            <input type="text" name="brand_name" 
                                   value="{{ old('brand_name', $settings['brand_name']->value ?? 'CraftByCode') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Displayed in navbars, copyright, and browser title</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Logo Display Mode
                            </label>
                            @php
                                $currentMode = old('logo_display_mode', $settings['logo_display_mode']->value ?? 'horizontal_logo');
                            @endphp
                            <select name="logo_display_mode" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="horizontal_logo" {{ $currentMode === 'horizontal_logo' ? 'selected' : '' }}>
                                    Horizontal Logo Image (Recommended)
                                </option>
                                <option value="smart_component" {{ $currentMode === 'smart_component' ? 'selected' : '' }}>
                                    Smart Dynamic Component (Icon + Gradient Text)
                                </option>
                            </select>
                            <p class="text-[11px] text-slate-400 mt-1">Choose between high-res image logo or dynamic CSS gradient component</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Primary Brand Tagline
                            </label>
                            <input type="text" name="brand_tagline" 
                                   value="{{ old('brand_tagline', $settings['brand_tagline']->value ?? 'Building Digital Solutions. Empowering Businesses.') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Appears below the brand logo in official displays and footers</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Sub-Tagline / Specializations
                            </label>
                            <input type="text" name="brand_sub_tagline" 
                                   value="{{ old('brand_sub_tagline', $settings['brand_sub_tagline']->value ?? 'UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Key service disciplines highlighted on brand badges</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Hero Trust Pill Badge
                            </label>
                            <input type="text" name="brand_badge" 
                                   value="{{ old('brand_badge', $settings['brand_badge']->value ?? 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Trust badge displayed above the main hero headline</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Company Elevator Pitch / Description
                            </label>
                            <textarea name="site_description" rows="3" 
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('site_description', $settings['site_description']->value ?? 'CraftByCode is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Main corporate overview displayed in the footer and metadata</p>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($group === 'hero')
            <!-- 2. HERO SECTION -->
            <div class="space-y-8">
                <!-- Mini Live Hero Preview -->
                <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-900 via-[#0B0F19] to-slate-950 text-white border border-slate-800 shadow-inner">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-3">Live Hero Preview</span>
                    <div class="max-w-xl mx-auto text-center space-y-3">
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ old('brand_badge', $settings['brand_badge']->value ?? 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE') }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                            <span>{{ old('hero_headline_1', $settings['hero_headline_1']->value ?? 'WE DESIGN.') }}</span>
                            <span class="text-slate-400">{{ old('hero_headline_2', $settings['hero_headline_2']->value ?? 'WE CODE.') }}</span><br>
                            <span class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent">
                                {{ old('hero_headline_gradient', $settings['hero_headline_gradient']->value ?? 'WE INNOVATE.') }}
                            </span>
                        </h2>
                        <p class="text-xs text-slate-400 line-clamp-2">
                            {{ old('hero_subtitle', $settings['hero_subtitle']->value ?? 'We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.') }}
                        </p>
                        <div class="flex items-center justify-center gap-3 pt-2">
                            <span class="px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs shadow-md">
                                {{ old('hero_cta_primary_text', $settings['hero_cta_primary_text']->value ?? 'Explore Services') }}
                            </span>
                            <span class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs border border-slate-700">
                                {{ old('hero_cta_secondary_text', $settings['hero_cta_secondary_text']->value ?? "Let's Talk") }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Main Hero Headlines -->
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Main Hero Headlines</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Headline Line 1
                            </label>
                            <input type="text" name="hero_headline_1" 
                                   value="{{ old('hero_headline_1', $settings['hero_headline_1']->value ?? 'WE DESIGN.') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">First major bold header phrase</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Headline Line 2
                            </label>
                            <input type="text" name="hero_headline_2" 
                                   value="{{ old('hero_headline_2', $settings['hero_headline_2']->value ?? 'WE CODE.') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Second major bold header phrase</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Gradient Highlight Line
                            </label>
                            <input type="text" name="hero_headline_gradient" 
                                   value="{{ old('hero_headline_gradient', $settings['hero_headline_gradient']->value ?? 'WE INNOVATE.') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Gradient highlighted callout line</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Hero Trust Pill Badge
                            </label>
                            <input type="text" name="brand_badge" 
                                   value="{{ old('brand_badge', $settings['brand_badge']->value ?? 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Badge that floats directly above the primary hero headline</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Hero Subtitle / Value Proposition
                            </label>
                            <textarea name="hero_subtitle" rows="3" 
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('hero_subtitle', $settings['hero_subtitle']->value ?? 'We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Supporting narrative that introduces CraftByCode to first-time visitors</p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Buttons -->
                <div class="pt-6 border-t border-slate-100 space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hero Action Buttons</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Primary CTA -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">Primary Action Button</span>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Button Text</label>
                                <input type="text" name="hero_cta_primary_text" 
                                       value="{{ old('hero_cta_primary_text', $settings['hero_cta_primary_text']->value ?? 'Explore Services') }}"
                                       class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Target Link URL</label>
                                <input type="text" name="hero_cta_primary_url" 
                                       value="{{ old('hero_cta_primary_url', $settings['hero_cta_primary_url']->value ?? '/services') }}"
                                       class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>

                        <!-- Secondary CTA -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Secondary Action Button</span>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Button Text</label>
                                <input type="text" name="hero_cta_secondary_text" 
                                       value="{{ old('hero_cta_secondary_text', $settings['hero_cta_secondary_text']->value ?? "Let's Talk") }}"
                                       class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Target Link URL</label>
                                <input type="text" name="hero_cta_secondary_url" 
                                       value="{{ old('hero_cta_secondary_url', $settings['hero_cta_secondary_url']->value ?? '/contact') }}"
                                       class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($group === 'stats')
            <!-- 3. COMPANY STATISTICS -->
            <div class="space-y-8">
                <!-- Visual Stats Counter Bar Preview -->
                <div class="p-6 rounded-2xl bg-slate-900 text-white border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-4">Homepage Stats Counter Preview</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center divide-y sm:divide-y-0 sm:divide-x divide-slate-800">
                        <div class="pt-2 sm:pt-0">
                            <div class="text-2xl sm:text-3xl font-extrabold text-blue-400">
                                {{ old('stat_clients_count', $settings['stat_clients_count']->value ?? '50+') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium mt-1">
                                {{ old('stat_clients_label', $settings['stat_clients_label']->value ?? 'Happy Clients') }}
                            </div>
                        </div>
                        <div class="pt-2 sm:pt-0">
                            <div class="text-2xl sm:text-3xl font-extrabold text-indigo-400">
                                {{ old('stat_projects_count', $settings['stat_projects_count']->value ?? '120+') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium mt-1">
                                {{ old('stat_projects_label', $settings['stat_projects_label']->value ?? 'Projects Completed') }}
                            </div>
                        </div>
                        <div class="pt-2 sm:pt-0">
                            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">
                                {{ old('stat_years_count', $settings['stat_years_count']->value ?? '5+') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium mt-1">
                                {{ old('stat_years_label', $settings['stat_years_label']->value ?? 'Years Experience') }}
                            </div>
                        </div>
                        <div class="pt-2 sm:pt-0">
                            <div class="text-2xl sm:text-3xl font-extrabold text-purple-400">
                                {{ old('stat_satisfaction_count', $settings['stat_satisfaction_count']->value ?? '98%') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium mt-1">
                                {{ old('stat_satisfaction_label', $settings['stat_satisfaction_label']->value ?? 'Client Satisfaction') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4 Statistics Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Stat 1: Happy Clients -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Stat Metric #1</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Clients</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Number / Counter</label>
                            <input type="text" name="stat_clients_count" 
                                   value="{{ old('stat_clients_count', $settings['stat_clients_count']->value ?? '50+') }}"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-base font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Display Label</label>
                            <input type="text" name="stat_clients_label" 
                                   value="{{ old('stat_clients_label', $settings['stat_clients_label']->value ?? 'Happy Clients') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <!-- Stat 2: Projects Completed -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Stat Metric #2</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800">Portfolio</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Number / Counter</label>
                            <input type="text" name="stat_projects_count" 
                                   value="{{ old('stat_projects_count', $settings['stat_projects_count']->value ?? '120+') }}"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-base font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Display Label</label>
                            <input type="text" name="stat_projects_label" 
                                   value="{{ old('stat_projects_label', $settings['stat_projects_label']->value ?? 'Projects Completed') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <!-- Stat 3: Years Experience -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Stat Metric #3</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Experience</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Number / Counter</label>
                            <input type="text" name="stat_years_count" 
                                   value="{{ old('stat_years_count', $settings['stat_years_count']->value ?? '5+') }}"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-base font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Display Label</label>
                            <input type="text" name="stat_years_label" 
                                   value="{{ old('stat_years_label', $settings['stat_years_label']->value ?? 'Years Experience') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <!-- Stat 4: Client Satisfaction -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-wider">Stat Metric #4</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800">Rating</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Number / Counter</label>
                            <input type="text" name="stat_satisfaction_count" 
                                   value="{{ old('stat_satisfaction_count', $settings['stat_satisfaction_count']->value ?? '98%') }}"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-base font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metric Display Label</label>
                            <input type="text" name="stat_satisfaction_label" 
                                   value="{{ old('stat_satisfaction_label', $settings['stat_satisfaction_label']->value ?? 'Client Satisfaction') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                </div>
            </div>

        @elseif($group === 'contact')
            <!-- 4. COMPANY CONTACT INFO -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Direct Communication Channels</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Official Company Email
                            </label>
                            <input type="email" name="contact_email" 
                                   value="{{ old('contact_email', $settings['contact_email']->value ?? 'hello@craftbycode.tech') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Recipient for customer inquiries, footer display, and lead generation</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Phone Number / Hotline
                            </label>
                            <input type="text" name="contact_phone" 
                                   value="{{ old('contact_phone', $settings['contact_phone']->value ?? '+1 (555) 019-2834') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Primary business voice / WhatsApp hotline</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Office / Headquarters Address
                            </label>
                            <input type="text" name="contact_address" 
                                   value="{{ old('contact_address', $settings['contact_address']->value ?? '100 Innovation Way, Suite 400, San Francisco, CA 94105') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Full physical mailing and office address</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Business Working Hours
                            </label>
                            <input type="text" name="contact_hours" 
                                   value="{{ old('contact_hours', $settings['contact_hours']->value ?? 'Monday - Friday: 9:00 AM - 6:00 PM EST') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Expected support and consultation availability window</p>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Interactive Location Map</h3>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Google Maps Embed Iframe URL
                        </label>
                        <textarea name="google_maps_url" rows="3" 
                                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('google_maps_url', $settings['google_maps_url']->value ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Must use an encrypted HTTPS URL originating from <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-700 font-mono">maps.google.com</code> or <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-700 font-mono">www.google.com</code>
                        </p>
                    </div>
                </div>
            </div>

        @elseif($group === 'social')
            <!-- 5. SOCIAL MEDIA LINKS -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Official Corporate Social Profiles</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- LinkedIn -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-[#0077B5] text-white flex items-center justify-center text-xs font-bold">in</div>
                                <label class="text-xs font-bold text-slate-800">LinkedIn Company Page</label>
                            </div>
                            <input type="text" name="social_linkedin" 
                                   value="{{ old('social_linkedin', $settings['social_linkedin']->value ?? 'https://linkedin.com/company/craftbycode') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- Twitter / X -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-black text-white flex items-center justify-center text-xs font-bold">𝕏</div>
                                <label class="text-xs font-bold text-slate-800">Twitter / X Handle URL</label>
                            </div>
                            <input type="text" name="social_twitter" 
                                   value="{{ old('social_twitter', $settings['social_twitter']->value ?? 'https://x.com/craftbycode') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- GitHub -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-[#24292e] text-white flex items-center justify-center text-xs font-bold">GH</div>
                                <label class="text-xs font-bold text-slate-800">GitHub Organization</label>
                            </div>
                            <input type="text" name="social_github" 
                                   value="{{ old('social_github', $settings['social_github']->value ?? 'https://github.com/craftbycode') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- Facebook -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-[#1877F2] text-white flex items-center justify-center text-xs font-bold">fb</div>
                                <label class="text-xs font-bold text-slate-800">Facebook Page URL</label>
                            </div>
                            <input type="text" name="social_facebook" 
                                   value="{{ old('social_facebook', $settings['social_facebook']->value ?? 'https://facebook.com/craftbycode') }}"
                                   class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-4">
                        These profiles are rendered in the site footer and registered in Schema.org <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-mono">sameAs</code> structured metadata.
                    </p>
                </div>
            </div>

        @elseif($group === 'cta')
            <!-- 6. CALL TO ACTION BANNER -->
            <div class="space-y-8">
                <!-- Live CTA Banner Preview -->
                <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white shadow-xl text-center space-y-4">
                    <span class="text-[10px] font-bold text-white/70 uppercase tracking-wider block">Live CTA Banner Preview</span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight">
                        {{ old('cta_title', $settings['cta_title']->value ?? "Let's build something amazing together") }}
                    </h2>
                    <p class="text-xs sm:text-sm text-blue-100 max-w-xl mx-auto">
                        {{ old('cta_subtitle', $settings['cta_subtitle']->value ?? "Have a project in mind? Let's turn your idea into reality.") }}
                    </p>
                    <div class="pt-2">
                        <span class="inline-block px-6 py-2.5 rounded-full bg-white text-blue-600 font-bold text-xs shadow-md">
                            {{ old('cta_button_text', $settings['cta_button_text']->value ?? 'Start a Project') }}
                        </span>
                    </div>
                </div>

                <!-- CTA Banner Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Banner Main Headline
                        </label>
                        <input type="text" name="cta_title" 
                               value="{{ old('cta_title', $settings['cta_title']->value ?? "Let's build something amazing together") }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Banner Subtitle / Value Hook
                        </label>
                        <textarea name="cta_subtitle" rows="2" 
                                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('cta_subtitle', $settings['cta_subtitle']->value ?? "Have a project in mind? Let's turn your idea into reality.") }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Action Button Label
                        </label>
                        <input type="text" name="cta_button_text" 
                               value="{{ old('cta_button_text', $settings['cta_button_text']->value ?? 'Start a Project') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Action Button Link URL
                        </label>
                        <input type="text" name="cta_button_url" 
                               value="{{ old('cta_button_url', $settings['cta_button_url']->value ?? '/contact') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

        @else
            <!-- DYNAMIC FALLBACK FOR ANY OTHER CUSTOM GROUP -->
            <div class="space-y-5">
                @foreach($settings as $setting)
                    @if(!in_array($setting->key, ['site_logo', 'site_logo_dark', 'site_logo_icon', 'site_logo_full']))
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

                            @if($setting->description)
                                <p class="text-[11px] text-slate-400 mt-1">{{ $setting->description }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">
                Save & Apply Dynamic Updates
            </button>
        </div>
    </form>
</div>
@endsection
