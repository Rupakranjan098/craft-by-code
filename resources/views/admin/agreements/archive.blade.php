@extends('layouts.admin')

@section('title', 'Legal Document Archive')
@section('header_title', 'Legal Document Archive')

@section('content')
<div class="space-y-6">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.agreements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Agreements Dashboard</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Legal Document Archive</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">Cryptographically sealed and e-stamped commercial contracts permanently archived in private storage.</p>
        </div>

        <form action="{{ route('admin.agreements.archive') }}" method="GET" class="relative max-w-xs w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search archived contracts..."
                   class="w-full pl-9 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-sm">
            <div class="absolute left-3 top-2.5 text-slate-400">
                <x-icon name="search" class="w-3.5 h-3.5" />
            </div>
        </form>
    </div>

    <!-- Archive Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Enforceable &amp; Finalized Contracts</h3>
            </div>
            <span class="text-xs font-semibold text-slate-400">Total: {{ $archivedAgreements->total() }} documents</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300 min-w-[960px]">
                <thead class="bg-slate-50/80 dark:bg-slate-800/60 text-slate-400 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-5 w-44">Agreement Ref</th>
                        <th class="py-3.5 px-4 min-w-[240px]">Contract Title &amp; Client</th>
                        <th class="py-3.5 px-4 w-32">Contract Value</th>
                        <th class="py-3.5 px-4 w-44">Digital Signature Hash</th>
                        <th class="py-3.5 px-4 w-36">e-Stamp Number</th>
                        <th class="py-3.5 px-5 w-36 text-right">Archived PDF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    @forelse($archivedAgreements as $agr)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-5 whitespace-nowrap">
                                <a href="{{ route('admin.agreements.show', $agr->id) }}" class="font-mono font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $agr->agreement_number }}
                                </a>
                                <div class="text-[10px] text-slate-400 mt-0.5">Finalized: {{ $agr->finalized_at ? $agr->finalized_at->format('M d, Y') : ($agr->updated_at ? $agr->updated_at->format('M d, Y') : '—') }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900 dark:text-white text-xs truncate max-w-[240px]">{{ $agr->title }}</div>
                                <div class="text-[11px] text-slate-400 truncate max-w-[240px]">{{ $agr->client_company ?: $agr->client_name }}</div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="font-bold text-slate-900 dark:text-white font-mono">
                                    {{ $agr->getFormattedValue() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono text-[10px] whitespace-nowrap">
                                @if($agr->hasDigitalSignature())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold" title="{{ $agr->digital_signature_hash }}">
                                        {{ substr($agr->digital_signature_hash, 0, 16) }}...
                                    </span>
                                @else
                                    <span class="text-slate-400">None</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-mono text-[10px] whitespace-nowrap">
                                @if($agr->hasEstamp())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-bold">
                                        {{ $agr->estamp_number }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Exempt</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.agreements.stream', $agr->id) }}" target="_blank"
                                       class="px-2.5 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 font-bold text-xs text-slate-700 dark:text-slate-300 transition">
                                        View
                                    </a>
                                    <a href="{{ route('admin.agreements.download', $agr->id) }}" 
                                       class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 font-bold text-xs text-white transition shadow-sm">
                                        Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                No archived contracts found. Finalize agreements on the dashboard to archive them here.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $archivedAgreements->links() }}
        </div>
    </div>
</div>
@endsection

