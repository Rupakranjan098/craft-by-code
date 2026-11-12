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
                'cta' => 'Call To Action Banner',
                'social' => 'Social Media Links',
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
            <!-- BRANDING & LOGO MODULE -->
            <div class="space-y-8">
                <!-- Live Visual Previews -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Live Logo Preview</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Light Navbar Preview -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Light Header / Navbar</span>
                            <div class="py-3 flex items-center justify-center bg-slate-50/50 rounded-xl min-h-[70px]">
                                <x-logo size="md" />
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 text-center">Used on light public pages</span>
                        </div>

                        <!-- Dark Sidebar Preview -->
                        <div class="p-5 rounded-2xl bg-[#080D19] border border-slate-800 shadow-sm flex flex-col justify-between text-white">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Dark Sidebar & Login</span>
                            <div class="py-3 flex items-center justify-center bg-white/5 rounded-xl min-h-[70px]">
                                <x-logo size="md" dark="true" />
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 text-center">Used in Admin & Dark Areas</span>
                        </div>

                        <!-- Favicon & Icon Preview -->
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
                        <!-- Primary Light Logo File -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Primary Website Logo (Light Background)</label>
                            <input type="file" name="site_logo_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo']->value ?? '/assets/images/logo-horizontal.png' }}</span></p>
                        </div>

                        <!-- Dark Mode Logo File -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Dark Mode Logo (Dark Sidebar & Login)</label>
                            <input type="file" name="site_logo_dark_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo_dark']->value ?? '/assets/images/logo-horizontal-dark.png' }}</span></p>
                        </div>

                        <!-- Logo Icon / Favicon File -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Logo Icon / Favicon (Square/Hexagon PNG)</label>
                            <input type="file" name="site_logo_icon_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Current: <span class="font-mono text-slate-700">{{ $settings['site_logo_icon']->value ?? '/assets/images/logo-icon-transparent.png' }}</span></p>
                        </div>

                        <!-- Full Graphic Logo Badge -->
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
                        <!-- Brand Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Company Brand Name
                            </label>
                            <input type="text" name="brand_name" 
                                   value="{{ old('brand_name', $settings['brand_name']->value ?? 'craft by code') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Displayed in navbars, copyright, and browser title</p>
                        </div>

                        <!-- Logo Display Mode -->
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
                            <p class="text-[11px] text-slate-400 mt-1">Choose between the high-res image logo or dynamic CSS gradient component</p>
                        </div>

                        <!-- Brand Tagline -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Primary Brand Tagline
                            </label>
                            <input type="text" name="brand_tagline" 
                                   value="{{ old('brand_tagline', $settings['brand_tagline']->value ?? 'CODE • DESIGN • SOLVE • INNOVATE') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Appears below the brand logo in official displays</p>
                        </div>

                        <!-- Sub-Tagline / Specializations -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Sub-Tagline / Specializations
                            </label>
                            <input type="text" name="brand_sub_tagline" 
                                   value="{{ old('brand_sub_tagline', $settings['brand_sub_tagline']->value ?? 'UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <p class="text-[11px] text-slate-400 mt-1">Key service disciplines highlighted on brand badges</p>
                        </div>

                        <!-- Brand Badge -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Hero Trust Pill Badge
                            </label>
                            <input type="text" name="brand_badge" 
                                   value="{{ old('brand_badge', $settings['brand_badge']->value ?? 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- Site Description -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Company Elevator Pitch / Description
                            </label>
                            <textarea name="site_description" rows="3" 
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('site_description', $settings['site_description']->value ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- OTHER TABS (HERO, STATS, CONTACT, CTA, SOCIAL) -->
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
