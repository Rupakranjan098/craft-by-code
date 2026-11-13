@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'CraftByCode');
    $tagline = \App\Models\WebsiteSetting::get('brand_tagline', 'Building Digital Solutions. Empowering Businesses.');
    $siteDesc = \App\Models\WebsiteSetting::get('site_description', 'We design, we code, we innovate. Building digital products that make a difference.');
    $contactEmail = \App\Models\WebsiteSetting::get('contact_email', 'hello@craftbycode.tech');
    $contactPhone = \App\Models\WebsiteSetting::get('contact_phone', '+1 (555) 019-2834');
    $contactAddress = \App\Models\WebsiteSetting::get('contact_address', '100 Innovation Way, Suite 400, San Francisco, CA');
    $socialLinkedin = \App\Models\WebsiteSetting::get('social_linkedin', 'https://linkedin.com');
    $socialTwitter = \App\Models\WebsiteSetting::get('social_twitter', 'https://x.com');
    $socialGithub = \App\Models\WebsiteSetting::get('social_github', 'https://github.com');
    $socialFacebook = \App\Models\WebsiteSetting::get('social_facebook', 'https://facebook.com');
@endphp

<footer class="bg-white dark:bg-[#080D19] border-t border-slate-100 dark:border-slate-800/80 text-slate-600 dark:text-slate-300 pt-14 sm:pt-16 pb-10 sm:pb-12 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 sm:gap-10 lg:gap-8 mb-12">
            <!-- Brand Column -->
            <div class="sm:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="inline-block">
                    <x-logo size="md" />
                </a>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm leading-relaxed">
                    {{ $siteDesc }}
                </p>
                <div class="flex items-center gap-3 pt-2">
                    @if($socialLinkedin && \App\Security\UrlValidator::isSafeHttpUrl($socialLinkedin))
                        <a href="{{ $socialLinkedin }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/60 text-slate-400 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center justify-center transition border border-slate-200 dark:border-slate-700">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.64 1.64 0 1 0 0-3.28 1.64 1.64 0 0 0 0 3.28m1.4 9.74v-8.37H5.06v8.37h2.8z"/></svg>
                        </a>
                    @endif
                    @if($socialTwitter && \App\Security\UrlValidator::isSafeHttpUrl($socialTwitter))
                        <a href="{{ $socialTwitter }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/60 text-slate-400 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center justify-center transition border border-slate-200 dark:border-slate-700">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if($socialGithub && \App\Security\UrlValidator::isSafeHttpUrl($socialGithub))
                        <a href="{{ $socialGithub }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/60 text-slate-400 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center justify-center transition border border-slate-200 dark:border-slate-700">
                            <span class="sr-only">GitHub</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>
                        </a>
                    @endif
                    @if($socialFacebook && \App\Security\UrlValidator::isSafeHttpUrl($socialFacebook))
                        <a href="{{ $socialFacebook }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/60 text-slate-400 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center justify-center transition border border-slate-200 dark:border-slate-700">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xs font-bold text-slate-900 dark:text-slate-100 tracking-wider uppercase mb-4">Quick Links</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Services</a></li>
                    <li><a href="{{ route('portfolio.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Portfolio</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">About Us</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Blog & Insights</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Contact</a></li>
                </ul>
            </div>

            <!-- Services Links -->
            <div>
                <h4 class="text-xs font-bold text-slate-900 dark:text-slate-100 tracking-wider uppercase mb-4">Services</h4>
                <ul class="space-y-2.5 text-sm">
                    @php
                        $footerServices = \App\Models\Service::active()->take(8)->get(['title', 'slug']);
                    @endphp
                    @forelse($footerServices as $fService)
                        <li><a href="{{ route('services.show', $fService->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">{{ $fService->title }}</a></li>
                    @empty
                        <li><a href="{{ route('services.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">All Services</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact & Newsletter -->
            <div class="sm:col-span-2 lg:col-span-1">
                <h4 class="text-xs font-bold text-slate-900 dark:text-slate-100 tracking-wider uppercase mb-4">Contact Us</h4>
                <div class="space-y-2 text-sm text-slate-500 dark:text-slate-400 mb-5">
                    <p class="flex items-center gap-2 min-w-0">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <a href="mailto:{{ $contactEmail }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition break-all">{{ $contactEmail }}</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>{{ $contactPhone }}</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                        <span class="line-clamp-2">{{ $contactAddress }}</span>
                    </p>
                </div>

                <h5 class="text-xs font-semibold text-slate-900 dark:text-slate-100 mb-2">Subscribe to our newsletter</h5>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative">
                    @csrf
                    <input type="email" name="email" required placeholder="Enter your email" 
                           class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl pl-3.5 pr-12 py-2.5 text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 w-9 bg-purple-600 hover:bg-purple-700 text-white rounded-lg flex items-center justify-center transition" aria-label="Subscribe">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Line -->
        <div class="pt-8 border-t border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 dark:text-slate-500 text-center sm:text-left">
            <p>© {{ date('Y') }} {{ $brandName }}. All rights reserved.</p>
            <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-5">
                <a href="{{ route('admin.login') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Admin Area</span>
                </a>
                <span class="hidden sm:inline">•</span>
                <span>{{ $tagline }}</span>
            </div>
        </div>
    </div>
</footer>
