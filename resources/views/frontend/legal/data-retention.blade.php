@extends('frontend.legal.layout')

@section('title', 'Data Deletion & Data Retention Policy | ' . $brandName . ' - Lifecycle & Erasure Rights')
@section('meta_description', 'Review ' . $brandName . ' data retention schedules, automated purging timelines, and verified client right-to-erasure and data deletion procedures.')
@section('canonical', route('legal.retention'))

@section('legal_title', 'Data Deletion & Retention Policy')
@section('legal_subtitle', 'Transparent data lifecycles, automated record purging schedules, and verified procedures for exercising your statutory right to data erasure.')

@section('legal_content')
    <article class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
        <!-- 1. Retention Principles -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">1</span>
                <span>Core Data Lifecycle Principles</span>
            </h2>
            <p>
                <strong>{{ $brandName }}</strong> adheres to strict data minimization and storage limitation principles under international data protection frameworks, including the EU/UK General Data Protection Regulation (GDPR) and the Indian Digital Personal Data Protection Act (DPDPA), 2023.
            </p>
            <p>
                We retain personal and technical information only for the duration strictly necessary to fulfill the business, engineering, and contractual purposes for which it was gathered, unless a longer retention period is explicitly required by applicable statutory, tax, or legal mandates.
            </p>
        </section>

        <!-- 2. Retention Schedules Table -->
        <section class="space-y-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">2</span>
                <span>Standard Data Retention Schedules</span>
            </h2>
            <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
                <table class="w-full text-left text-xs divide-y divide-slate-200 dark:divide-slate-800">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-700 dark:text-slate-200 uppercase tracking-wider font-bold text-[11px]">
                        <tr>
                            <th class="p-3.5 sm:p-4">Data Category</th>
                            <th class="p-3.5 sm:p-4">Scope &amp; Description</th>
                            <th class="p-3.5 sm:p-4">Retention Window</th>
                            <th class="p-3.5 sm:p-4">Disposal Method</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-600 dark:text-slate-300">
                        <tr>
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">Website Inquiries &amp; Leads</td>
                            <td class="p-3.5 sm:p-4">Contact form submissions, project quote requests, and chatbot consultation leads.</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-blue-600 dark:text-blue-400">12 Months</td>
                            <td class="p-3.5 sm:p-4">Automated database purge of inactive inquiries.</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">Active Client Deliverables</td>
                            <td class="p-3.5 sm:p-4">Design files, sprint specifications, source code branches, and staging databases.</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-emerald-600 dark:text-emerald-400">Contract Term + 90 Days SLA</td>
                            <td class="p-3.5 sm:p-4">Repository handover and staging environment decommissioning.</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">Invoicing &amp; Tax Records</td>
                            <td class="p-3.5 sm:p-4">Commercial invoices, payment transaction receipts, and accounting statements.</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-purple-600 dark:text-purple-400">7 Years (Statutory)</td>
                            <td class="p-3.5 sm:p-4">Encrypted cold archive until statutory tax period expiry.</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">Server &amp; Security Logs</td>
                            <td class="p-3.5 sm:p-4">Access logs, firewall events, IP request telemetry, and administrative audit trails.</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-amber-600 dark:text-amber-400">90 to 180 Days</td>
                            <td class="p-3.5 sm:p-4">Automated log rotation and cryptographic sanitization.</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">Newsletter Subscriptions</td>
                            <td class="p-3.5 sm:p-4">Subscriber email addresses for engineering insights.</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-indigo-600 dark:text-indigo-400">Until Unsubscribed</td>
                            <td class="p-3.5 sm:p-4">Immediate suppression and permanent deletion within 14 days.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 3. Deletion Procedures -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">3</span>
                <span>Data Sanitization &amp; Deletion Procedures</span>
            </h2>
            <p>
                When data reaches the end of its designated retention period or upon fulfillment of a verified user erasure request, {{ $brandName }} applies irreversible sanitization methods:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Relational Database Sanitization:</strong> Hard deletion of database rows. Overwriting primary key references to prevent reconstructive data carving.</li>
                <li><strong>Non-Volatile Storage Zeroing:</strong> Deletion of private attachments and temporary assets using secure file destruction routines conforming to NIST SP 800-88 guidelines.</li>
                <li><strong>Backup Cycling:</strong> Production backups overwrite in rolling 14-to-30 day cycles, ensuring deleted records naturally expire from disaster recovery snapshots without residual traces.</li>
            </ul>
        </section>

        <!-- 4. How to Request Deletion -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">4</span>
                <span>Submitting a Data Deletion Request (Right to Erasure)</span>
            </h2>
            <p>
                Any individual or prospective client whose personal data has been processed by {{ $brandName }} has the statutory right to request permanent erasure.
            </p>
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-3 text-xs">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">Step-by-Step Deletion Protocol:</h3>
                <ol class="list-decimal pl-5 space-y-1.5 text-slate-600 dark:text-slate-300">
                    <li>
                        Email our Data Protection Desk at <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a> with the subject line <strong>"Data Deletion Request"</strong>.
                    </li>
                    <li>
                        Specify the email address used during your contact or consultation request to allow us to locate your record.
                    </li>
                    <li>
                        Our team will verify your identity (via a verification confirmation email to the recorded address) to protect against unauthorized or malicious deletion attempts.
                    </li>
                    <li>
                        Upon verification, all associated inquiry records, contact details, and messaging histories will be permanently purged within <strong>30 calendar days</strong>, and a final written confirmation will be delivered to your inbox.
                    </li>
                </ol>
            </div>
        </section>

        <!-- 5. Exceptions to Deletion -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">5</span>
                <span>Statutory Exceptions to Deletion</span>
            </h2>
            <p>
                In compliance with applicable laws, {{ $brandName }} may withhold deletion of specific records only where strictly required for:
            </p>
            <ul class="list-disc pl-5 space-y-1 text-xs">
                <li>Compliance with mandatory corporate accounting and tax reporting obligations.</li>
                <li>Establishment, exercise, or defense of active legal claims or formal commercial disputes.</li>
                <li>Detection and prevention of financial fraud, security breaches, or system abuse.</li>
            </ul>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                In such exceptional circumstances, affected records will be isolated, access-restricted, and strictly blocked from any active processing until the statutory retention requirement lapses.
            </p>
        </section>

        <!-- 6. Contact -->
        <section class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">6</span>
                <span>Data Retention Desk</span>
            </h2>
            <p>
                For inquiries regarding our retention schedules or to check the status of a pending deletion request:
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-1">
                <p><strong>{{ $brandName }} Data Protection &amp; Retention Desk</strong></p>
                <p>Email: <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a></p>
                <p>Subject: "Attn: Data Retention Officer"</p>
                <p>Processing Fee: Completely free of charge</p>
            </div>
        </section>
    </article>
@endsection
