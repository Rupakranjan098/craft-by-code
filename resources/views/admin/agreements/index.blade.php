@extends('layouts.admin')

@section('title', 'Agreement & Contract Management')
@section('header_title', 'Agreement & Contract Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Quick Links -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                    Strict Admin-Only
                </span>
                <span class="text-xs text-slate-400 dark:text-slate-500">Legal &amp; Contract Office</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">Digital Agreements &amp; Contracts</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">Manage client contracts, digital signatures, e-Stamp certificates, and legal archives.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.agreements.archive') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition">
                <x-icon name="shield-check" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" />
                <span>Legal Archive</span>
            </a>
            <a href="{{ route('admin.agreements.templates.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition">
                <x-icon name="layers" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                <span>Templates</span>
            </a>
            <a href="{{ route('admin.agreements.audit-logs') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition">
                <x-icon name="clock" class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" />
                <span>Audit Trail</span>
            </a>
            <a href="{{ route('admin.agreements.settings') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition">
                <x-icon name="building" class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" />
                <span>Settings</span>
            </a>
            @if(Auth::user()->hasPermission('agreements.manage'))
                <a href="{{ route('admin.agreements.create') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-md hover:shadow-lg">
                    <x-icon name="plus" class="w-3.5 h-3.5" />
                    <span>Generate Agreement</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Metrics Dashboard Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 sm:gap-4">
        <!-- Total -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">Total</span>
            <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $metrics['total'] }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">All contracts</div>
        </div>

        <!-- Draft -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">Drafts</span>
            <div class="text-xl sm:text-2xl font-black text-slate-700 dark:text-slate-300 mt-1">{{ $metrics['draft'] }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">In preparation</div>
        </div>

        <!-- Pending Signature -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400">Pending Sign</span>
            <div class="text-xl sm:text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ $metrics['pending_signature'] }}</div>
            <div class="text-[10px] text-amber-600/70 mt-0.5">Awaiting sign</div>
        </div>

        <!-- Fully Signed -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400">Fully Signed</span>
            <div class="text-xl sm:text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ $metrics['fully_signed'] }}</div>
            <div class="text-[10px] text-indigo-600/70 mt-0.5">Signed &amp; sealed</div>
        </div>

        <!-- E-Stamp Pending -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400">e-Stamp Pending</span>
            <div class="text-xl sm:text-2xl font-black text-rose-600 dark:text-rose-400 mt-1">{{ $metrics['estamp_pending'] }}</div>
            <div class="text-[10px] text-rose-600/70 mt-0.5">Needs certificate</div>
        </div>

        <!-- Active -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Active</span>
            <div class="text-xl sm:text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $metrics['active'] }}</div>
            <div class="text-[10px] text-emerald-600/70 mt-0.5">Live contracts</div>
        </div>

        <!-- Total Value -->
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-blue-600 dark:text-blue-400">Value (USD)</span>
            <div class="text-base sm:text-lg font-black text-blue-600 dark:text-blue-400 mt-1">${{ number_format($metrics['total_value']) }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Active portfolio</div>
        </div>
    </div>

    <!-- Status Filter Tabs & Search Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex items-center gap-1 bg-white dark:bg-slate-900 p-1.5 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-xs font-semibold shadow-sm overflow-x-auto">
            <a href="{{ route('admin.agreements.index') }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white dark:bg-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                All ({{ $metrics['total'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'draft']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'draft' ? 'bg-slate-900 text-white dark:bg-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Draft ({{ $metrics['draft'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'pending_signature']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'pending_signature' ? 'bg-amber-600 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Pending Signature ({{ $metrics['pending_signature'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'fully_signed']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'fully_signed' ? 'bg-indigo-600 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Signed ({{ $metrics['fully_signed'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'estamp_pending']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'estamp_pending' ? 'bg-rose-600 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                e-Stamp Pending ({{ $metrics['estamp_pending'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'active']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'active' ? 'bg-emerald-600 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Active ({{ $metrics['active'] }})
            </a>
            <a href="{{ route('admin.agreements.index', ['status' => 'cancelled']) }}" 
               class="px-3 py-1.5 rounded-xl transition whitespace-nowrap {{ request('status') === 'cancelled' ? 'bg-rose-700 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Cancelled ({{ $metrics['cancelled'] }})
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.agreements.index') }}" method="GET" class="relative max-w-xs w-full">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search agreement #, title, client..."
                   class="w-full pl-9 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-sm">
            <div class="absolute left-3 top-2.5 text-slate-400">
                <x-icon name="search" class="w-3.5 h-3.5" />
            </div>
        </form>
    </div>

    <!-- Agreements Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50/70 dark:bg-slate-800/60 text-slate-400 dark:text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-6">Agreement Number</th>
                        <th class="py-3.5 px-6">Agreement Title &amp; Category</th>
                        <th class="py-3.5 px-6">Client &amp; Company</th>
                        <th class="py-3.5 px-6">Contract Value</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Digital Seal / e-Stamp</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                    @forelse($agreements as $agr)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.agreements.show', $agr->id) }}" class="font-mono font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $agr->agreement_number }}
                                </a>
                                <div class="text-[10px] text-slate-400">{{ $agr->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <div class="font-bold text-slate-900 dark:text-white truncate">{{ $agr->title }}</div>
                                <span class="inline-block text-[10px] text-slate-400">{{ $agr->template?->category ?: 'Bespoke Software' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $agr->client_company ?: $agr->client_name }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $agr->client_email }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900 dark:text-white text-sm">
                                    {{ $agr->getFormattedValue() }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($agr->status === 'active')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        ● Active
                                    </span>
                                @elseif($agr->status === 'fully_signed')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                        ● Fully Signed
                                    </span>
                                @elseif($agr->status === 'pending_signature')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                        ● Pending Sign
                                    </span>
                                @elseif($agr->status === 'estamp_pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                        ● e-Stamp Pending
                                    </span>
                                @elseif($agr->status === 'cancelled')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700">
                                        ✕ Cancelled
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col gap-1">
                                    @if($agr->hasDigitalSignature())
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                            <x-icon name="check-circle" class="w-3 h-3" /> Signed
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-400">Unsigned</span>
                                    @endif

                                    @if($agr->hasEstamp())
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 dark:text-amber-400 font-mono">
                                            <x-icon name="stamp" class="w-3 h-3" /> {{ substr($agr->estamp_number, 0, 10) }}...
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.agreements.show', $agr->id) }}" 
                                       class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition">
                                        Manage
                                    </a>
                                    <a href="{{ route('admin.agreements.download', $agr->id) }}" 
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition" 
                                       title="Download Agreement PDF">
                                        <x-icon name="download" class="w-4 h-4" />
                                    </a>
                                    @if(in_array($agr->status, ['draft', 'cancelled']))
                                        <form action="{{ route('admin.agreements.destroy', $agr->id) }}" method="POST" onsubmit="return confirm('Permanently delete this draft agreement?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Delete Draft">
                                                <x-icon name="trash" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                No agreements found matching this criteria. Click "+ Generate Agreement" to start a new client contract.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $agreements->links() }}
        </div>
    </div>
</div>
@endsection
