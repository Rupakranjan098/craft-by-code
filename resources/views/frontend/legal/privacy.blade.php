@extends('frontend.legal.layout')

@section('title', 'Privacy Policy | ' . $brandName . ' - Data Protection & Client Confidentiality')
@section('meta_description', 'Official Privacy Policy of ' . $brandName . '. Learn how we collect, process, encrypt, and protect personal and client technical data in accordance with modern data privacy standards.')
@section('canonical', route('legal.privacy'))

@section('legal_title', 'Privacy Policy')
@section('legal_subtitle', 'Our commitment to safeguarding your privacy, client project data, and personal information across all Craft by Code digital touchpoints.')

@section('legal_content')
    <article class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
        <!-- 1. Introduction -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">1</span>
                <span>Introduction &amp; Scope</span>
            </h2>
            <p>
                Welcome to <strong>{{ $brandName }}</strong> ("we", "our", or "us"). We provide custom software engineering, startup MVP development, SaaS platform architecture, and digital product consulting to global clients.
            </p>
            <p>
                This Privacy Policy explains how {{ $brandName }} collects, uses, discloses, and protects information when you visit our website at 
                <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">{{ url('/') }}</a>, 
                submit project inquiries, engage our engineering consultation services, or communicate with our team.
            </p>
            <div class="p-4 rounded-xl bg-blue-50/60 dark:bg-blue-950/40 border border-blue-200/80 dark:border-blue-900/60 text-xs text-blue-950 dark:text-blue-200">
                <strong>Digital Operations Notice:</strong> {{ $brandName }} operates digitally as a remote-first technology studio. We do not display fictitious office locations or unverified commercial registration numbers. Official electronic communications must be directed to 
                <a href="mailto:{{ $officialEmail }}" class="underline font-bold">{{ $officialEmail }}</a>.
            </div>
        </section>

        <!-- 2. Information We Collect -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">2</span>
                <span>Information We Collect</span>
            </h2>
            <p>
                We collect information directly provided by you, as well as technical data gathered automatically through your interaction with our website:
            </p>
            <ul class="list-disc pl-5 space-y-2">
                <li>
                    <strong>Voluntarily Provided Information:</strong> When you submit a contact inquiry, request a software development quote, or subscribe to our insights newsletter, we may collect your name, business email address, phone number, company or startup name, service interests, project budget parameters, and technical scope notes.
                </li>
                <li>
                    <strong>Chatbot &amp; Consultation Inquiries:</strong> Messages, technical project questions, and contact lead details submitted via our dynamic website AI assistant.
                </li>
                <li>
                    <strong>Technical &amp; Log Data:</strong> Internet Protocol (IP) address, browser user-agent, operating system, referring URL, pages visited, timestamps, and request latency collected for DDoS mitigation, bot protection, and security auditing.
                </li>
                <li>
                    <strong>Device &amp; Analytics Data:</strong> Aggregated screen resolution, device category (desktop/mobile/tablet), and interaction telemetry tracked via Google Analytics 4 with mandatory IP anonymization.
                </li>
            </ul>
        </section>

        <!-- 3. How We Use Your Information -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">3</span>
                <span>How We Use Your Information</span>
            </h2>
            <p>We process collected data exclusively for legitimate commercial, engineering, and security purposes, including:</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Proposal &amp; Scoping</strong>
                    Evaluating software architecture, estimating MVP timelines, and preparing tailored technical proposals.
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Direct Client Support</strong>
                    Communicating updates, answering inquiries, and coordinating technical discovery meetings.
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Platform Security</strong>
                    Preventing spam, mitigating brute-force attacks, verifying CSRF tokens, and maintaining audit logs.
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Legal &amp; Tax Compliance</strong>
                    Complying with applicable statutory accounting, tax, and cyber regulations.
                </div>
            </div>
            <p class="font-semibold text-rose-600 dark:text-rose-400 text-xs">
                We do not sell, rent, monetize, or trade your personal or project data with external advertising brokers under any circumstances.
            </p>
        </section>

        <!-- 4. Cookies & Web Tracking -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">4</span>
                <span>Cookies &amp; Local Storage</span>
            </h2>
            <p>Our website utilizes minimal, privacy-centric cookies and browser storage mechanisms:</p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Strictly Necessary Cookies:</strong> Anti-CSRF session tokens (<code class="text-xs bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">XSRF-TOKEN</code>) essential for secure form submissions and administrative authentication.</li>
                <li><strong>Functional Storage:</strong> Client-side theme preference flags (<code class="text-xs bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">theme</code>) stored in browser <code class="text-xs bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">localStorage</code> to remember your Day/Night UI state.</li>
                <li><strong>Performance Analytics:</strong> Google Analytics 4 cookies with IP anonymization enabled by default to measure aggregate traffic without individual profiling.</li>
            </ul>
        </section>

        <!-- 5. Data Protection Rights -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">5</span>
                <span>Your Data Protection Rights</span>
            </h2>
            <p>
                Depending on your geographic location (including under the EU/UK General Data Protection Regulation (GDPR) and the Indian Digital Personal Data Protection Act (DPDPA), 2023), you hold the following rights:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Right to Access:</strong> Request a copy of the personal information {{ $brandName }} holds regarding you.</li>
                <li><strong>Right to Rectification:</strong> Request correction of inaccurate or incomplete contact or commercial details.</li>
                <li><strong>Right to Erasure (Right to be Forgotten):</strong> Request permanent deletion of your inquiry records, subject to statutory retention obligations.</li>
                <li><strong>Right to Restrict or Object to Processing:</strong> Request suspension of non-essential data processing.</li>
                <li><strong>Right to Data Portability:</strong> Receive your provided data in a structured, commonly used, machine-readable format.</li>
            </ul>
            <p>
                To exercise any of these rights, submit a written request to <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a>. We respond to all verified requests within 30 calendar days at zero charge.
            </p>
        </section>

        <!-- 6. Third-Party Service Providers -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">6</span>
                <span>Third-Party Subprocessors</span>
            </h2>
            <p>
                We work with reputable, industry-standard infrastructure and service providers bound by comprehensive Data Processing Agreements (DPAs):
            </p>
            <ul class="list-disc pl-5 space-y-1 text-xs">
                <li><strong>Hosting &amp; Compute:</strong> Secure cloud providers hosting our containerized applications and relational databases with at-rest AES-256 encryption.</li>
                <li><strong>Transactional Email:</strong> Enterprise SMTP relays for inbound inquiry routing and client communications.</li>
                <li><strong>Analytics:</strong> Google Analytics 4 (configured with IP masking and strict retention controls).</li>
            </ul>
        </section>

        <!-- 7. Security Standards -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">7</span>
                <span>Data Security Architecture</span>
            </h2>
            <p>
                We employ comprehensive technical and organizational measures (TOMs), including TLS 1.3 encryption in transit, strict Content Security Policy (CSP), rate-limiting barriers, OWASP ASVS verification, and role-based access control. For a comprehensive overview, review our dedicated <a href="{{ route('legal.security') }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Data Security Policy</a>.
            </p>
        </section>

        <!-- 8. Policy Updates -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">8</span>
                <span>Revisions to this Policy</span>
            </h2>
            <p>
                We may revise this Privacy Policy periodically to reflect technological advancements, operational updates, or statutory amendments. Material revisions will be posted on this page with an updated "Last Updated" date.
            </p>
        </section>

        <!-- 9. Contact -->
        <section class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">9</span>
                <span>Contacting Our Privacy Team</span>
            </h2>
            <p>
                For questions, concerns, or requests relating to this Privacy Policy or our data handling practices, please contact:
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-1">
                <p><strong>{{ $brandName }} Privacy &amp; Compliance Desk</strong></p>
                <p>Email: <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a></p>
                <p>Subject: "Privacy Inquiry / Data Protection Request"</p>
                <p>Support Hours: Monday – Friday: 9:30 AM – 6:30 PM IST</p>
            </div>
        </section>
    </article>
@endsection

