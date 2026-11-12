@props([
    'size' => 'md',
    'showTagline' => false,
    'dark' => false,
    'onlyIcon' => false,
    'fullBadge' => false,
])

@php
    $displayMode = \App\Models\WebsiteSetting::get('logo_display_mode', 'horizontal_logo');
    $siteLogo = \App\Models\WebsiteSetting::get('site_logo', '/assets/images/logo-horizontal.png');
    $siteLogoDark = \App\Models\WebsiteSetting::get('site_logo_dark', '/assets/images/logo-horizontal-dark.png');
    $siteLogoIcon = \App\Models\WebsiteSetting::get('site_logo_icon', '/assets/images/logo-icon-transparent.png');
    $siteLogoFull = \App\Models\WebsiteSetting::get('site_logo_full', '/assets/images/logo.png');
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
    $tagline = \App\Models\WebsiteSetting::get('brand_tagline', 'CODE • DESIGN • SOLVE • INNOVATE');

    $iconSizes = [
        'sm' => 'w-7 h-7',
        'md' => 'w-9 h-9',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
    ];

    $imageHeights = [
        'sm' => 'h-7',
        'md' => 'h-9',
        'lg' => 'h-11',
        'xl' => 'h-14',
    ];

    $textSizes = [
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
        'xl' => 'text-2xl',
    ];

    $words = explode(' ', trim($brandName));
    $hasDarkModeProp = filter_var($dark, FILTER_VALIDATE_BOOLEAN);
@endphp

@if($onlyIcon)
    <div class="{{ $iconSizes[$size] ?? 'w-9 h-9' }} relative flex-shrink-0">
        <img src="{{ asset(ltrim($siteLogoIcon, '/')) }}" 
             alt="{{ $brandName }} Icon" 
             class="w-full h-full object-contain drop-shadow-sm transition-transform hover:scale-105 duration-200">
    </div>
@elseif($fullBadge)
    <div class="flex flex-col items-center text-center">
        <img src="{{ asset(ltrim($siteLogoFull, '/')) }}" 
             alt="{{ $brandName }}" 
             class="max-w-xs w-full h-auto rounded-3xl object-contain drop-shadow-md border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 p-3">
    </div>
@elseif($displayMode === 'horizontal_logo' && $siteLogo)
    <div class="inline-flex flex-col">
        @if($hasDarkModeProp && $siteLogoDark)
            <img src="{{ asset(ltrim($siteLogoDark, '/')) }}" 
                 alt="{{ $brandName }}" 
                 class="{{ $imageHeights[$size] ?? 'h-9' }} w-auto object-contain transition-transform hover:scale-[1.02] duration-200">
        @else
            <img src="{{ asset(ltrim($siteLogo, '/')) }}" 
                 alt="{{ $brandName }}" 
                 class="{{ $imageHeights[$size] ?? 'h-9' }} w-auto object-contain transition-transform hover:scale-[1.02] duration-200 {{ $siteLogoDark ? 'dark:hidden' : '' }}">
            @if($siteLogoDark)
                <img src="{{ asset(ltrim($siteLogoDark, '/')) }}" 
                     alt="{{ $brandName }}" 
                     class="{{ $imageHeights[$size] ?? 'h-9' }} w-auto object-contain transition-transform hover:scale-[1.02] duration-200 hidden dark:block">
            @endif
        @endif

        @if($showTagline)
            <span class="text-[9px] font-bold tracking-wider {{ $hasDarkModeProp ? 'text-slate-400' : 'text-slate-500 dark:text-slate-400' }} uppercase mt-1 pl-1">
                {{ $tagline }}
            </span>
        @endif
    </div>
@else
    {{-- Smart Component Mode with Icon + Styled Gradient Typography --}}
    <div class="inline-flex items-center gap-2.5 font-bold tracking-tight">
        <div class="{{ $iconSizes[$size] ?? 'w-9 h-9' }} relative flex-shrink-0">
            <img src="{{ asset(ltrim($siteLogoIcon, '/')) }}" 
                 alt="{{ $brandName }} Icon" 
                 class="w-full h-full object-contain drop-shadow-sm transition-transform hover:scale-105 duration-200">
        </div>

        <div class="flex flex-col">
            <span class="{{ $textSizes[$size] ?? 'text-lg' }} font-black {{ $hasDarkModeProp ? 'text-white' : 'text-slate-900 dark:text-white' }} leading-tight tracking-tight flex items-center">
                @if(count($words) === 3)
                    <span>{{ $words[0] }}</span>
                    <span class="mx-1 text-blue-600 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent font-black">{{ $words[1] }}</span>
                    <span>{{ $words[2] }}</span>
                @elseif(count($words) === 2)
                    <span>{{ $words[0] }}</span>
                    <span class="ml-1 text-blue-600 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent font-black">{{ $words[1] }}</span>
                @else
                    <span>{{ $brandName }}</span>
                @endif
            </span>
            @if($showTagline)
                <span class="text-[8.5px] font-bold tracking-wider {{ $hasDarkModeProp ? 'text-slate-400' : 'text-slate-500 dark:text-slate-400' }} uppercase mt-0.5">
                    {{ $tagline }}
                </span>
            @endif
        </div>
    </div>
@endif
