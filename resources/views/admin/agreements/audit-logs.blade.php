@extends('layouts.admin')

@section('title', 'Agreement Security Audit Trail')
@section('header_title', 'Agreement Audit Logs')

@section('content')
<div class="space-y-6">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.agreements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Agreements Dashboard</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Security &amp; Legal Audit Trail</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">Tamper-evident chronological activity log of all contract generations, digital signatures, e-Stamps, and downloads.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-300">
                Total Events: {{ $logs->total() }}
            </span>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50/70 dark:bg-slate-800/60 text-slate-400 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6">Timestamp</th>
                        <th class="py-3.5 px-6">Action</th>
                        <th class="py-3.5 px-6">Agreement Ref</th>
                        <th class="py-3.5 px-6">User / Actor</th>
                        <th class="py-3.5 px-6">Event Details</th>
                        <th class="py-3.5 px-6">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-6 text-slate-400 text-[11px] whitespace-nowrap">
                                {{ $log->created_at->format('M d, Y H:i:s') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider font-mono
                                    {{ $log->action === 'digitally_signed' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800' :
                                       ($log->action === 'estamp_attached' ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 border border-amber-200 dark:border-amber-800' :
                                       ($log->action === 'pdf_downloaded' ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 border border-blue-200 dark:border-blue-800' :
                                       'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400')) }}">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($log->agreement)
                                    <a href="{{ route('admin.agreements.show', $log->agreement->id) }}" class="font-mono font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $log->agreement->agreement_number }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Global System</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800 dark:text-slate-200">
                                {{ $log->user?->name ?: 'Admin / System' }}
                            </td>
                            <td class="py-4 px-6 max-w-sm truncate text-slate-700 dark:text-slate-300">
                                {{ $log->details }}
                            </td>
                            <td class="py-4 px-6 font-mono text-[11px] text-slate-400">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                No security audit events recorded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
