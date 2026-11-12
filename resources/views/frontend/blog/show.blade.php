@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
    $authorName = trim((string) ($post->author_name ?? $brandName));
    $authorParts = preg_split('/\s+/', $authorName) ?: [];
    $authorInitials = count($authorParts) >= 2
        ? strtoupper(mb_substr($authorParts[0], 0, 1) . mb_substr($authorParts[1], 0, 1))
        : strtoupper(mb_substr($authorName ?: 'CB', 0, 2));
    $postOgImage = \App\Security\UrlValidator::isSafeHttpUrl((string) $post->image)
        ? $post->image
        : asset(ltrim((string) $post->image, '/'));
@endphp

@section('title', $post->title . ' | ' . $brandName . ' Blog')
@section('meta_description', $post->excerpt)
@section('canonical', route('blog.show', $post->slug))
@section('og_type', 'article')
@section('og_image', $postOgImage)

@push('schema')
@php
    $blogSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->excerpt,
        'image' => $postOgImage,
        'datePublished' => optional($post->published_at ?? $post->created_at)->toAtomString(),
        'dateModified' => optional($post->updated_at ?? $post->published_at ?? $post->created_at)->toAtomString(),
        'author' => [
            '@type' => 'Person',
            'name' => $authorName,
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $brandName,
            'url' => route('home'),
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => route('blog.show', $post->slug),
        ],
    ];
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('blog.show', $post->slug)],
        ],
    ];
@endphp
<script type="application/ld+json" nonce="{{ $cspNonce ?? '' }}">
    {!! json_encode($blogSchema, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json" nonce="{{ $cspNonce ?? '' }}">
    {!! json_encode($breadcrumbSchema, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    <article class="py-12 sm:py-16 lg:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400 mb-5 sm:mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a>
                <span>/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Blog</a>
                <span>/</span>
                <span class="text-slate-900 dark:text-white font-semibold truncate max-w-[200px] sm:max-w-none">{{ $post->title }}</span>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/80 inline-block mb-4">
                {{ $post->category }}
            </span>

            <h1 class="text-2xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>

            <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 pb-2">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center flex-shrink-0">
                    {{ $authorInitials }}
                </div>
                <div>
                    <span class="font-bold text-slate-900 dark:text-white block">{{ $post->author_name }}</span>
                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }} • {{ $post->read_time }}</span>
                </div>
            </div>
        </div>
    </article>

    <!-- Main Content -->
    <div class="py-12 sm:py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl overflow-hidden shadow-xl mb-10 sm:mb-12 bg-slate-900">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-auto object-cover max-h-[480px]">
        </div>

        <div class="prose prose-base sm:prose-lg prose-slate dark:prose-invert max-w-none leading-relaxed text-slate-700 dark:text-slate-300 space-y-6">
            <p class="text-lg sm:text-xl font-medium text-slate-800 dark:text-slate-200 leading-relaxed border-l-4 border-blue-600 pl-4 py-1 italic bg-blue-50/30 dark:bg-blue-950/30 rounded-r-xl">
                {{ $post->excerpt }}
            </p>

            <div class="content space-y-4 pt-4 overflow-x-auto break-words">
                {!! \App\Security\HtmlSanitizer::sanitize($post->content) !!}
            </div>
        </div>

        <!-- Author Footer Card -->
        <div class="mt-12 sm:mt-16 p-6 sm:p-8 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-blue-600 to-purple-600 text-white font-bold text-xl flex items-center justify-center flex-shrink-0 shadow">
                {{ $authorInitials }}
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">{{ $post->author_name }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Senior engineering contributor at {{ $brandName }}. Focused on building fault-tolerant backend architectures, performant user interfaces, and automated AI pipelines.
                </p>
            </div>
        </div>

        <!-- Related Posts -->
        @if($recentPosts->isNotEmpty())
            <div class="mt-16 sm:mt-20 pt-10 sm:pt-12 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white mb-6 sm:mb-8">Related Articles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($recentPosts as $rec)
                        <a href="{{ route('blog.show', $rec->slug) }}" class="group block rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="h-32 bg-slate-900 overflow-hidden">
                                <img src="{{ $rec->image }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4">
                                <span class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 block mb-1">{{ $rec->category }}</span>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition line-clamp-2">{{ $rec->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-cta-banner />
@endsection

