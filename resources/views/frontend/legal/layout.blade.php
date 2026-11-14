@extends('layouts.app')

@section('content')
    <!-- Hero / Header Strip -->
    <section class="py-14 sm:py-20 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/60 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>Legal &amp; Regulatory Compliance</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-4">
                    @yield('legal_title')
                </h1>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                    @yield('legal_subtitle')
                </p>

                <!-- Dates & Metadata Strip -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-semibold">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        <span>Effective: <strong class="text-slate-900 dark:text-white">{{ $effectiveDate }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        <span>Last Updated: <strong class="text-slate-900 dark:text-white">{{ $lastUpdatedDate }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $officialEmail }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="py-12 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Sidebar Navigation (4 cols) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                <!-- Policy Index Card -->
                <div class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Legal Documentation</h2>
                    <nav class="space-y-1.5">
                        <a href="{{ route('legal.privacy') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('legal.privacy') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span>Privacy Policy</span>
                            </span>
                            @if(request()->routeIs('legal.privacy'))
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>

                        <a href="{{ route('legal.terms') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('legal.terms') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                <span>Terms &amp; Conditions</span>
                            </span>
                            @if(request()->routeIs('legal.terms'))
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>

                        <a href="{{ route('legal.security') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('legal.security') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <span>Data Security Policy</span>
                            </span>
                            @if(request()->routeIs('legal.security'))
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>

                        <a href="{{ route('legal.retention') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('legal.retention') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                <span>Data Deletion &amp; Retention</span>
                            </span>
                            @if(request()->routeIs('legal.retention'))
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>

                        <a href="{{ route('legal.grievance') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('legal.grievance') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <span>Grievance Officer</span>
                            </span>
                            @if(request()->routeIs('legal.grievance'))
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>
                    </nav>
                </div>

                <!-- Transparency & Verification Card -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/40 dark:from-slate-900/90 dark:to-blue-950/20 border border-slate-200 dark:border-slate-800 text-xs space-y-3">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span>Authenticity Guarantee</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $brandName }} operates on principles of strict transparency. We do not publish fictitious registration credentials or synthetic addresses.
                    </p>
                    <div class="pt-2 border-t border-slate-200/80 dark:border-slate-800/80 text-[11px] text-slate-500 dark:text-slate-400">
                        Official Correspondence: <br>
                        <a href="mailto:{{ $officialEmail }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline">{{ $officialEmail }}</a>
                    </div>
                </div>

                <!-- Commercial Engagements Notice -->
                <div class="p-5 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 text-xs space-y-2">
                    <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
                        <span>Client Contracts &amp; MSAs</span>
                    </h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-[11px]">
                        Individual software development deliverables, non-disclosure agreements, and milestone contracts are executed privately with verified client entities via our secure administrative infrastructure.
                    </p>
                </div>
            </aside>

            <!-- Main Legal Body (8 cols) -->
            <main class="lg:col-span-8 bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 lg:p-12 shadow-sm space-y-10">
                @yield('legal_content')

                <!-- Bottom Support Strip -->
                <div class="pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">Have questions about our legal policies?</p>
                        <p class="text-slate-500 dark:text-slate-400">Our compliance desk is available Monday through Friday.</p>
                    </div>
                    <a href="mailto:{{ $officialEmail }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <span>Contact Compliance</span>
                    </a>
                </div>
            </main>
        </div>
    </section>
@endsection
