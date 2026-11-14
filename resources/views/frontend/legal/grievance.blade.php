@extends('frontend.legal.layout')

@section('title', 'Grievance Officer & Contact Information | ' . $brandName . ' - Compliance & Redressal')
@section('meta_description', 'Official Grievance Officer details, compliance mechanism, escalation procedures, and contact information for ' . $brandName . ' under applicable IT & data protection regulations.')
@section('canonical', route('legal.grievance'))

@section('legal_title', 'Grievance Officer & Contact Information')
@section('legal_subtitle', 'Statutory compliance details, formal dispute redressal mechanism, and dedicated communication channels for Craft by Code.')

@section('legal_content')
    <article class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-sm leading-relaxed text-slate-700 dark:text-slate-300">
        <!-- 1. Statutory Context -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">1</span>
                <span>Regulatory Framework &amp; Purpose</span>
            </h2>
            <p>
                In accordance with <strong>Rule 3(2) of the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021</strong>, the <strong>Information Technology Act, 2000</strong>, and applicable digital data protection standards, <strong>{{ $brandName }}</strong> has instituted a transparent Grievance Redressal Mechanism.
            </p>
            <p>
                This framework provides any user, prospective client, researcher, or member of the public with an accessible and timely channel to report grievances, privacy concerns, intellectual property matters, or security incidents relating to our website and services.
            </p>
        </section>

        <!-- 2. Grievance Officer Contact Details -->
        <section class="space-y-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">2</span>
                <span>Designated Grievance Officer</span>
            </h2>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/50 dark:from-slate-800/80 dark:to-blue-950/30 border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-1">Official Compliance Appointee</span>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white">Grievance &amp; Compliance Officer</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Department of Legal Affairs &amp; Regulatory Compliance</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                        Active Redressal Desk
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-200/80 dark:border-slate-800 text-xs">
                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-semibold block mb-0.5">Appointed Designation</span>
                        <span class="font-bold text-slate-900 dark:text-white">Head of Legal, Privacy &amp; Compliance</span>
                        <span class="text-[11px] text-slate-400 block">(Designated Statutory Representative)</span>
                    </div>

                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-semibold block mb-0.5">Organization</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $brandName }}</span>
                        <span class="text-[11px] text-slate-400 block">Digital Software &amp; Product Engineering Studio</span>
                    </div>

                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-semibold block mb-0.5">Official Redressal Email</span>
                        <a href="mailto:{{ $officialEmail }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline text-sm">{{ $officialEmail }}</a>
                        <span class="text-[11px] text-slate-400 block">Use Subject: "Attn: Grievance Officer"</span>
                    </div>

                    <div>
                        <span class="text-slate-400 dark:text-slate-500 font-semibold block mb-0.5">Working Hours</span>
                        <span class="font-bold text-slate-900 dark:text-white">Monday – Friday: 10:00 AM – 6:00 PM IST</span>
                        <span class="text-[11px] text-slate-400 block">Excluding recognized national holidays</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400">
                    <strong class="text-slate-900 dark:text-white block mb-1">Authentic Operating Notice:</strong>
                    {{ $brandName }} operates as a remote-first digital technology studio. In strict adherence to truth-in-advertising and legal authenticity guidelines, we do not publish synthetic physical street addresses or unverified registration credentials. Formal correspondence, statutory notices, and legal grievances are received and processed electronically with full legal validity via <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold underline">{{ $officialEmail }}</a>.
                </div>
            </div>
        </section>

        <!-- 3. Redressal Mechanism & Timelines -->
        <section class="space-y-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">3</span>
                <span>Redressal Mechanism &amp; Response Timelines</span>
            </h2>
            <p>
                Our Grievance Redressal Desk operates under strict service level agreements (SLAs) designed to guarantee thorough and prompt handling:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Phase 1: Acknowledgment</span>
                    </div>
                    <p class="font-bold text-slate-900 dark:text-white text-sm">Within 24 to 48 Hours</p>
                    <p class="text-slate-600 dark:text-slate-400">
                        Every filed grievance is registered with a unique Tracking Ticket ID and an acknowledgment is dispatched to the complainant's email address.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider text-[11px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 12 2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
                        <span>Phase 2: Investigation &amp; Resolution</span>
                    </div>
                    <p class="font-bold text-slate-900 dark:text-white text-sm">Within 15 Working Days</p>
                    <p class="text-slate-600 dark:text-slate-400">
                        The Grievance Officer coordinates with technical, security, or executive teams to investigate the complaint, implement remedial actions, and issue a formal written determination.
                    </p>
                </div>
            </div>
        </section>

        <!-- 4. How to Submit a Grievance -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">4</span>
                <span>Filing Procedure &amp; Required Information</span>
            </h2>
            <p>
                To enable swift triage and resolution, ensure your grievance communication includes the following particulars:
            </p>
            <ul class="list-disc pl-5 space-y-1.5 text-xs">
                <li><strong>Complainant Identity:</strong> Full legal name, official title, and valid telephone contact number.</li>
                <li><strong>Entity / Capacity:</strong> Indication whether you are filing as an individual user, client representative, or authorized legal counsel.</li>
                <li><strong>Subject Line:</strong> Clearly formatted as <code class="bg-slate-100 dark:bg-slate-900 px-1.5 py-0.5 rounded font-mono text-[11px]">GRIEVANCE: [Concise Description of Issue]</code>.</li>
                <li><strong>Factual Narrative:</strong> A detailed, chronologically ordered statement describing the incident, affected URL/service, and nature of harm or infringement.</li>
                <li><strong>Supporting Evidence:</strong> Any relevant screenshots, log excerpts, or email transcripts that substantiate the claim.</li>
                <li><strong>Requested Remediation:</strong> The specific remedial action requested (e.g., data erasure, content modification, or administrative clarification).</li>
            </ul>
        </section>

        <!-- 5. Escalation Matrix -->
        <section class="space-y-3">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">5</span>
                <span>Escalation Protocol</span>
            </h2>
            <p>
                If a complainant does not receive an acknowledgment within 48 hours or is not satisfied with the determination issued by the Grievance Officer:
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-2">
                <p class="font-bold text-slate-900 dark:text-white">Senior Leadership Review:</p>
                <p>
                    The matter may be escalated directly to the Executive Leadership Committee by replying to the ticket thread with <strong>"ESCALATION REQUEST - EXECUTIVE REVIEW"</strong> in the subject line. An independent executive review will be conducted within seven (7) business days.
                </p>
            </div>
        </section>

        <!-- 6. Summary Contact -->
        <section class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-black inline-flex items-center justify-center">6</span>
                <span>Direct Contact Channel</span>
            </h2>
            <p>
                All compliance correspondence and statutory notices must be sent to:
            </p>
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-xs space-y-1">
                <p><strong>{{ $brandName }} Grievance &amp; Compliance Cell</strong></p>
                <p>Email: <a href="mailto:{{ $officialEmail }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">{{ $officialEmail }}</a></p>
                <p>Subject: "Attn: Grievance Officer"</p>
                <p>Operating Hours: Monday – Friday: 10:00 AM – 6:00 PM IST</p>
            </div>
        </section>
    </article>
@endsection

