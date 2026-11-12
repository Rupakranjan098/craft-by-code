@extends('layouts.app')

@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

@section('title', 'About Us | ' . $brandName . ' - Craftsmanship & Digital Innovation')
@section('meta_description', 'Learn about ' . $brandName . ', our mission, vision, core values, development methodology, and our passionate team of software craftsmen.')

@section('content')
    <!-- Hero / Intro -->
    <section class="py-16 sm:py-20 lg:py-24 gradient-hero border-b border-slate-100 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-3">About {{ $brandName }}</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-6">
                Transforming Ideas Into <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Digital Solutions</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl mx-auto">
                {{ $intro->content ?? 'Founded with a passion for software craftsmanship, CraftByCode empowers startups and enterprises with high-velocity digital solutions.' }}
            </p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block">Our Journey</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    {{ $story->title ?? 'Born to Build Better Software' }}
                </h2>
                <div class="text-slate-600 dark:text-slate-300 space-y-4 text-base leading-relaxed">
                    <p>
                        {{ $story->content ?? 'CraftByCode started as a tight-knit collective of seasoned engineers and product designers frustrated with bureaucratic agencies that overpromised and underdelivered.' }}
                    </p>
                    <p>
                        We resolved to construct an engineering firm centered on transparent communication, clean code craftsmanship, and relentless commitment to client success. Over the past 5+ years, we have grown into a trusted technology partner for startups, unicorns, and established businesses across North America, Europe, and Asia.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800">
                        <div class="text-2xl font-black text-slate-900 dark:text-white mb-0.5">120+</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">Projects Shipped Globally</div>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800">
                        <div class="text-2xl font-black text-slate-900 dark:text-white mb-0.5">98%</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">Client Retention &amp; Satisfaction</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="relative rounded-3xl overflow-hidden bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 p-6 sm:p-8 shadow-2xl text-white">
                    <div class="space-y-6">
                        <div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center">
                            <x-icon name="sparkles" class="w-6 h-6 text-white" />
                        </div>
                        <h3 class="text-2xl font-extrabold">The {{ $brandName }} Philosophy</h3>
                        <p class="text-blue-100 text-sm leading-relaxed">
                            "We believe code is an art form backed by rigorous mathematical discipline. Every architecture decision we make aims to deliver measurable business leverage to our clients."
                        </p>
                        <div class="pt-4 border-t border-white/20 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold flex-shrink-0">
                                <x-logo size="sm" :onlyIcon="true" />
                            </div>
                            <div>
                                <div class="text-sm font-bold">Engineering Leadership</div>
                                <div class="text-xs text-blue-200">{{ $brandName }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-14 sm:py-20 bg-slate-50/70 dark:bg-slate-900/40 border-y border-slate-100 dark:border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                <div class="p-7 sm:p-10 rounded-3xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-6">
                            <x-icon name="globe" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-2">Our Mission</span>
                        <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-4">Empowering Modern Enterprises</h3>
                        <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                            {{ $missionVision->data['mission'] ?? 'Empowering modern enterprises through bespoke digital solutions that drive operational agility, revenue growth, and unforgettable customer experiences.' }}
                        </p>
                    </div>
                </div>

                <div class="p-7 sm:p-10 rounded-3xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-6">
                            <x-icon name="sparkles" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400 block mb-2">Our Vision</span>
                        <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-4">Setting New Engineering Standards</h3>
                        <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                            {{ $missionVision->data['vision'] ?? 'To be the world’s most trusted software partner for innovators who refuse to compromise on quality, security, or design.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Values -->
    <section class="py-16 sm:py-20 lg:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-2">Company Values</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Core values that drive every line of code
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $valList = $values->data ?? [
                    ['title' => 'Craftsmanship First', 'description' => 'We don’t cut corners. Every database query, API endpoint, and UI component is architected for clean readability and long-term durability.'],
                    ['title' => 'Radical Transparency', 'description' => 'Direct engineer-to-client communication with zero jargon. You always have full access to our git repositories and sprint progress.'],
                    ['title' => 'User-Centric Innovation', 'description' => 'Technology serves humans. We build software that is intuitive, empathetic, and effortless to adopt.'],
                    ['title' => 'Speed Without Compromise', 'description' => 'We launch high-velocity MVPs and features fast by leveraging modern tooling without sacrificing security or scalability.']
                ];
            @endphp

            @foreach($valList as $index => $val)
                <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl dark:hover:border-slate-700 transition-all duration-300 hover:-translate-y-1">
                    <div class="text-xs font-mono font-bold text-blue-600 dark:text-blue-400 mb-4">0{{ $index + 1 }} //</div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $val['title'] }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $val['description'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 5-Step Development Process -->
    <section class="py-16 sm:py-20 bg-slate-900 dark:bg-slate-900/95 border-y dark:border-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-400 block mb-2">Our Methodology</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Our 5-Step Development Process
                </h2>
                <p class="text-slate-400 text-sm mt-3">A battle-tested agile methodology delivering predictable outcomes from day one.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $steps = $process->data ?? [
                        ['step' => '01', 'title' => 'Discovery', 'description' => 'Deep dive into business goals, requirements & architecture blueprint.'],
                        ['step' => '02', 'title' => 'UI/UX Design', 'description' => 'Clickable wireframes and high-fidelity Figma design systems.'],
                        ['step' => '03', 'title' => 'Agile Build', 'description' => 'Two-week iterative sprints with continuous live staging previews.'],
                        ['step' => '04', 'title' => 'QA & Security', 'description' => 'End-to-end automated testing, load testing and vulnerability scans.'],
                        ['step' => '05', 'title' => 'Deployment', 'description' => 'Zero-downtime release with 24/7 proactive monitoring & SLA support.']
                    ];
                @endphp

                @foreach($steps as $s)
                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/60 flex flex-col justify-between hover:border-blue-500 transition">
                        <div>
                            <span class="text-3xl font-black text-blue-400 block mb-3">{{ $s['step'] }}</span>
                            <h3 class="text-base font-bold text-white mb-2">{{ $s['title'] }}</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">{{ $s['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 sm:py-20 lg:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-2">Our Leadership</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Meet the minds behind {{ $brandName }}
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $teamMembers = $team->data ?? [
                    ['name' => 'Alexander Hayes', 'role' => 'Founder & CTO', 'bio' => '12+ years building enterprise SaaS and distributed cloud architectures.', 'image' => '/assets/images/team/team-1.jpg'],
                    ['name' => 'Maya Lin', 'role' => 'Head of UX Design', 'bio' => 'Former design lead at Silicon Valley scale-ups with focus on conversion UI.', 'image' => '/assets/images/team/team-2.jpg'],
                    ['name' => 'Marcus Vance', 'role' => 'Lead Full-Stack Architect', 'bio' => 'Specializes in high-throughput Laravel APIs, database clustering and security.', 'image' => '/assets/images/team/team-3.jpg'],
                    ['name' => 'Chloe Bennett', 'role' => 'AI & Cloud Infrastructure', 'bio' => 'Expert in LLM integration, automated agent workflows and Kubernetes.', 'image' => '/assets/images/team/team-4.jpg']
                ];
            @endphp

            @foreach($teamMembers as $m)
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-lg dark:hover:border-slate-700 transition text-center flex flex-col items-center">
                    <img src="{{ $m['image'] }}" alt="{{ $m['name'] }}" class="w-24 h-24 rounded-full mb-4 object-cover shadow-inner">
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $m['name'] }}</h4>
                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 mb-2">{{ $m['role'] }}</span>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $m['bio'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Why Businesses Trust Us -->
    <section class="py-14 sm:py-20 bg-slate-50/70 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12 sm:mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-2">The {{ $brandName }} Advantage</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Why businesses trust {{ $brandName }}
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4">
                        <x-icon name="shield-check" class="w-5 h-5" />
                    </div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">100% IP Ownership</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">You own all source code, assets, and documentation with zero vendor lock-in.</p>
                </div>

                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4">
                        <x-icon name="code" class="w-5 h-5" />
                    </div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">Zero Tech Debt</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Standard-compliant, fully tested PHP 8.4, Laravel, and modern JavaScript components.</p>
                </div>

                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-4">
                        <x-icon name="clock" class="w-5 h-5" />
                    </div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">Agile Velocity</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Two-week transparent sprint cycles with daily asynchronous updates.</p>
                </div>

                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-4">
                        <x-icon name="briefcase" class="w-5 h-5" />
                    </div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">24/7 SLA Support</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Proactive uptime monitoring and dedicated engineering response guarantees.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <x-cta-banner />
@endsection
