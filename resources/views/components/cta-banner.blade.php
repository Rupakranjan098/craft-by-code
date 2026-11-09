@php
    $ctaTitle = \App\Models\WebsiteSetting::get('cta_title', "Let's build something amazing together");
    $ctaSubtitle = \App\Models\WebsiteSetting::get('cta_subtitle', "Have a project in mind? Let's turn your idea into reality.");
    $ctaBtnText = \App\Models\WebsiteSetting::get('cta_button_text', "Start a Project");
    $ctaBtnUrl = \App\Models\WebsiteSetting::get('cta_button_url', "/contact");
@endphp

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-16">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 sm:p-12 lg:p-14 shadow-xl text-white">
        <!-- Background subtle glow/mesh pattern -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -top-20 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-5 sm:gap-6 text-left">
                <!-- Code icon badge -->
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center flex-shrink-0 border border-white/20 shadow-inner">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <polyline points="16 18 22 12 16 6"/>
                        <polyline points="8 6 2 12 8 18"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-1.5">
                        {{ $ctaTitle }}
                    </h3>
                    <p class="text-blue-100 text-sm sm:text-base font-normal">
                        {{ $ctaSubtitle }}
                    </p>
                </div>
            </div>

            <!-- Action button -->
            <div class="flex-shrink-0 w-full md:w-auto text-center">
                <a href="{{ $ctaBtnUrl }}" 
                   class="inline-flex items-center justify-center w-full md:w-auto px-8 py-3.5 text-sm font-bold text-slate-900 bg-white hover:bg-slate-50 rounded-full transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 group">
                    <span>{{ $ctaBtnText }}</span>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

