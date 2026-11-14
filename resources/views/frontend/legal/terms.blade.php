@extends('frontend.legal.layout')

@section('title', 'Terms & Conditions | ' . $brandName . ' - Software Engineering & Digital Services')
@section('meta_description', 'Read ' . $brandName . ' Terms and Conditions governing website usage, software engineering services, intellectual property, acceptable conduct, and commercial engagements.')
@section('canonical', route('legal.terms'))

@section('legal_title', 'Terms & Conditions')
@section('legal_subtitle', 'Governing principles, acceptable usage standards, and commercial contractual frameworks for Craft by Code services and digital platforms.')

@section('legal_content')
    <article class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
        <!-- 1. Acceptance -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">1</span>
                <span>Agreement to Terms</span>
            </h2>
            <p>
                These Terms and Conditions ("Terms") constitute a legally binding agreement between you (whether personally or on behalf of an entity) and <strong>{{ $brandName }}</strong> ("we", "our", or "us"), governing your access to and use of our website (<a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">{{ url('/') }}</a>) and related digital channels.
            </p>
            <p>
                By accessing our website, browsing our portfolio, reading our technical publications, or submitting project inquiries, you acknowledge that you have read, understood, and agreed to be bound by these Terms and our companion <a href="{{ route('legal.privacy') }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Privacy Policy</a>.
            </p>
        </section>

        <!-- 2. Services Overview -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">2</span>
                <span>Technology Services &amp; Scope</span>
            </h2>
            <p>
                {{ $brandName }} delivers premium digital engineering and software consultancy services, including but not limited to:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Custom Software &amp; Web Applications:</strong> High-performance full-stack web platforms, microservices, and enterprise portals.</li>
                <li><strong>Startup MVP Engineering:</strong> Rapid prototype sprints, user-validation builds, and seed-ready minimum viable products.</li>
                <li><strong>Mobile Application Development:</strong> Cross-platform and native iOS/Android applications built for scalability.</li>
                <li><strong>Cloud Architecture &amp; DevOps:</strong> Container orchestration, automated CI/CD pipelines, security hardening, and AWS/GCP/Azure migrations.</li>
                <li><strong>AI Automation &amp; Intelligent Workflows:</strong> LLM integration, custom autonomous agents, and business process automation.</li>
            </ul>
        </section>

        <!-- 3. Commercial Contracts & MSAs -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">3</span>
                <span>Commercial Engagements &amp; Master Services Agreements</span>
            </h2>
            <p>
                The informational material published on this website is for general marketing and scoping purposes only and does not constitute a unilateral commercial offer.
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-2">
                <p class="font-bold text-slate-900 dark:text-white">Formal Contracting Framework:</p>
                <p>
                    All active client software engineering projects, deliverables, milestones, fee structures, service level agreements (SLAs), and warranty provisions are governed exclusively by a separate, bilateral <strong>Master Services Agreement (MSA)</strong> or <strong>Statement of Work (SOW)</strong> negotiated and formally executed between {{ $brandName }} and the client.
                </p>
                <p class="text-slate-500 dark:text-slate-400 text-[11px]">
                    To maintain strict confidentiality and enterprise security, client contracts, digital signatures, e-Stamps, and audit trails are managed exclusively through our private, access-controlled backend infrastructure.
                </p>
            </div>
        </section>

        <!-- 4. Intellectual Property -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">4</span>
                <span>Intellectual Property Rights</span>
            </h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>
                    <strong>{{ $brandName }} Proprietary Assets:</strong> All trademarks, logos, visual layouts, website designs, audio-visual materials, and proprietary text content appearing on this website are the sole property of {{ $brandName }} and are protected by applicable intellectual property and copyright laws.
                </li>
                <li>
                    <strong>Client Project Deliverables:</strong> Ownership of custom source code, design systems, and software intellectual property engineered for clients is transferred in accordance with the specific terms and payment completion criteria defined in each client's executed Master Services Agreement.
                </li>
            </ul>
        </section>

        <!-- 5. User Conduct & Acceptable Use -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">5</span>
                <span>Acceptable Conduct &amp; Restrictions</span>
            </h2>
            <p>You agree not to engage in any of the following prohibited activities:</p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs text-rose-700 dark:text-rose-400">
                <li>Attempting to probe, scan, or test the vulnerability of our systems without explicit written authorization from our security team.</li>
                <li>Initiating Denial of Service (DoS/DDoS) attacks, automated scraping, or excessive bulk request generation intended to disrupt service availability.</li>
                <li>Injecting malicious software, SQL payloads, cross-site scripting (XSS) vectors, or backdoors into inquiry forms or chatbot prompts.</li>
                <li>Misrepresenting your identity or providing fraudulent company credentials when submitting project inquiries.</li>
                <li>Attempting unauthorized access to restricted administrative panels or document storage vaults.</li>
            </ul>
        </section>

        <!-- 6. Disclaimer of Warranties -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">6</span>
                <span>Warranties &amp; Disclaimers</span>
            </h2>
            <p>
                This website and its content are provided on an "as-is" and "as-available" basis without representations or warranties of any kind, whether express or implied. While we strive for absolute accuracy and 99.9% uptime, we do not guarantee uninterrupted, error-free website operation.
            </p>
            <p>
                Specific engineering warranties, bug-fix windows, and response SLAs apply solely to paid engagements under executed client contracts.
            </p>
        </section>

        <!-- 7. Limitation of Liability -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">7</span>
                <span>Limitation of Liability</span>
            </h2>
            <p>
                To the maximum extent permitted by applicable law, in no event shall {{ $brandName }}, its founders, employees, or contractors be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your access to or inability to use this website.
            </p>
        </section>

        <!-- 8. Governing Law & Dispute Resolution -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">8</span>
                <span>Governing Law &amp; Dispute Resolution</span>
            </h2>
            <p>
                These Terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law principles. Parties agree that any dispute arising out of or in connection with these Terms shall first be attempted to be resolved amicably through good-faith negotiation. If unresolved within thirty (30) days, disputes shall be subject to arbitration in accordance with applicable arbitration rules.
            </p>
        </section>

        <!-- 9. Contact -->
        <section class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">9</span>
                <span>Questions &amp; Legal Notices</span>
            </h2>
            <p>
                For legal inquiries, contract verification, or terms clarification, please email our legal counsel desk:
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-1">
                <p><strong>{{ $brandName }} Legal Affairs</strong></p>
                <p>Official Contact Email: <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a></p>
                <p>Subject: "Terms &amp; Conditions Inquiry"</p>
            </div>
        </section>
    </article>
@endsection

