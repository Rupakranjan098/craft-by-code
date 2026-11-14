@extends('frontend.legal.layout')

@section('title', 'Data Security Policy | ' . $brandName . ' - Enterprise Infrastructure & Encryption Standards')
@section('meta_description', 'Explore ' . $brandName . ' technical and organizational data security policies, including TLS 1.3/AES-256 encryption, access control, multi-factor authentication, and secure SDLC.')
@section('canonical', route('legal.security'))

@section('legal_title', 'Data Security Policy')
@section('legal_subtitle', 'Enterprise technical and organizational measures (TOMs) engineered to safeguard client intellectual property, databases, and digital infrastructure.')

@section('legal_content')
    <article class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
        <!-- 1. Security Philosophy -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">1</span>
                <span>Security Governance &amp; Philosophy</span>
            </h2>
            <p>
                At <strong>{{ $brandName }}</strong>, security is an architectural cornerstone embedded into every phase of our software development lifecycle. We design and operate our platforms to comply with the highest industry standards, drawing directly from the <strong>OWASP Top 10</strong>, <strong>OWASP Application Security Verification Standard (ASVS)</strong>, and <strong>ISO/IEC 27001</strong> security principles.
            </p>
            <p>
                This policy outlines the technical, operational, and organizational security controls implemented across our website, communication gateways, and engineering environments.
            </p>
        </section>

        <!-- 2. Cryptographic Architecture -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">2</span>
                <span>Cryptographic &amp; Encryption Architecture</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span>In-Transit Encryption</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300">
                        100% of network traffic is encrypted using <strong>TLS 1.3</strong> (and TLS 1.2 with strong ephemeral Diffie-Hellman cipher suites). HTTP Strict Transport Security (HSTS) is enforced with <code class="bg-slate-100 dark:bg-slate-900 px-1 py-0.5 rounded font-mono">max-age=31536000; includeSubDomains; preload</code> to eliminate downgrade vulnerabilities.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span>At-Rest Encryption</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300">
                        All relational database volumes, automated backups, and storage disks utilize industry-standard <strong>AES-256</strong> block cipher encryption. Passwords and sensitive secrets are hashed using salted <strong>Bcrypt</strong> with high algorithmic cost factors.
                    </p>
                </div>

                <div class="sm:col-span-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 12 2 2 4-4"/><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Document Integrity &amp; Cryptographic Signatures</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300">
                        Internal agreements, contract PDFs, and verification receipts compute dual-layer cryptographic proofs: an <strong>HMAC-SHA256</strong> digital signature digest combined with a <strong>SHA-256</strong> document hash stored in immutable audit logs to guarantee non-repudiation and prevent tampering.
                    </p>
                </div>
            </div>
        </section>

        <!-- 3. Application Security Controls -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">3</span>
                <span>Application-Layer Defensive Engineering</span>
            </h2>
            <ul class="list-disc pl-5 space-y-2 text-xs">
                <li>
                    <strong>SQL Injection Neutralization:</strong> Zero raw concatenated SQL strings. All queries leverage prepared statements and parameterized bindings via the Laravel Eloquent ORM.
                </li>
                <li>
                    <strong>Cross-Site Scripting (XSS) Prevention:</strong> Automatic HTML entity escaping across all Blade templates, strict sanitization of user-submitted inquiries, and dynamic Content Security Policy (CSP) headers restricting script execution.
                </li>
                <li>
                    <strong>Cross-Site Request Forgery (CSRF):</strong> Cryptographic, per-session anti-CSRF token verification enforced on every mutating HTTP request (POST, PUT, PATCH, DELETE).
                </li>
                <li>
                    <strong>Rate Limiting &amp; Anti-Abuse:</strong> Intelligent Redis/cache-backed throttlers applied to inbound contact forms (5 req/min), newsletter subscriptions (5 req/min), chatbot messaging (20 req/min), and administrative login attempts (5 req/15 min) with exponential IP lockouts.
                </li>
                <li>
                    <strong>Session Hardening:</strong> Session cookies configured with <code class="bg-slate-100 dark:bg-slate-900 px-1 py-0.5 rounded font-mono">HttpOnly; Secure; SameSite=Lax</code> to prevent client-side JavaScript access and cross-origin leakage.
                </li>
            </ul>
        </section>

        <!-- 4. Infrastructure & Hosting -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">4</span>
                <span>Cloud Infrastructure &amp; Network Isolation</span>
            </h2>
            <p>
                Our production infrastructure resides within dedicated Virtual Private Clouds (VPCs) with strict ingress/egress firewall rules:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>No Public Database Exposure:</strong> Production databases and cache layers are strictly confined to private subnets with zero direct public internet accessibility.</li>
                <li><strong>Non-Executable Upload Storage:</strong> Client media and uploaded project files are stored in private directories outside the webroot and served exclusively via secure streaming proxies with MIME-type re-validation.</li>
                <li><strong>DDoS &amp; Bot Defense:</strong> Enterprise reverse-proxy edge caches filter distributed denial-of-service volumetric surges before reaching origin application servers.</li>
            </ul>
        </section>

        <!-- 5. Administrative Access & RBAC -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">5</span>
                <span>Administrative Access &amp; Least Privilege</span>
            </h2>
            <p>
                Administrative access to backend control panels requires multi-layer authentication:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Multi-Factor Authentication (MFA/2FA):</strong> Mandatory RFC 6238 time-based one-time password (TOTP) authenticator verification for all administrator accounts.</li>
                <li><strong>Role-Based Access Control (RBAC):</strong> Granular permissions restricting sensitive functions (such as contract generation, system settings, and audit log inspection) to authorized roles.</li>
                <li><strong>Immutable Audit Logging:</strong> Security-critical administrative events are recorded with IP addresses, browser fingerprints, actor IDs, and precise microsecond timestamps.</li>
            </ul>
        </section>

        <!-- 6. Secure SDLC -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">6</span>
                <span>Secure Software Development Lifecycle (SDLC)</span>
            </h2>
            <p>
                Every line of software produced for clients and internal systems passes through automated security quality gates:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Automated CI/CD</strong>
                    Comprehensive feature, unit, and integration test suites run automatically before code can be merged into production branches.
                </div>
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Dependency Auditing</strong>
                    Composer and npm dependencies are scanned continuously for Common Vulnerabilities and Exposures (CVEs).
                </div>
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Mandatory Peer Review</strong>
                    No changes reach production without independent architectural and security review by senior engineering leads.
                </div>
            </div>
        </section>

        <!-- 7. Responsible Disclosure -->
        <section class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">7</span>
                <span>Vulnerability Reporting &amp; Responsible Disclosure</span>
            </h2>
            <p>
                We welcome reports from independent security researchers and white-hat community members. If you discover a potential security vulnerability within our web assets or APIs:
            </p>
            <ol class="list-decimal pl-5 space-y-1 text-xs">
                <li>Submit a detailed vulnerability report to <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a> with the subject <em>"Security Vulnerability Report"</em>.</li>
                <li>Include reproducible proof-of-concept steps, affected endpoints, and suggested remediation.</li>
                <li>Allow our engineering team reasonable time (minimum 7 business days) to triage and patch before public disclosure.</li>
                <li>Avoid executing tests that cause denial of service or compromise other users' private information.</li>
            </ol>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-1">
                <p><strong>Security Operations &amp; Incident Response Desk</strong></p>
                <p>Dedicated Security Email: <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a></p>
                <p>Response SLA: Initial acknowledgment within 24 hours.</p>
            </div>
        </section>
    </article>
@endsection
