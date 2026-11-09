@extends('layouts.admin')

@section('title', 'Customer Inquiries')
@section('header_title', 'Contact Inquiries')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Contact Inquiries</h1>
                <p class="text-xs text-slate-500">Review incoming leads, service inquiries, and project proposals</p>
            </div>
            <!-- Status Filter Tabs -->
            <div class="flex items-center gap-1.5 bg-white p-1 rounded-2xl border border-slate-200/80 text-xs font-semibold shadow-sm">
                <a href="{{ route('admin.inquiries.index') }}" 
                   class="px-3 py-1.5 rounded-xl transition {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    All
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" 
                   class="px-3 py-1.5 rounded-xl transition {{ request('status') === 'new' ? 'bg-rose-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    New
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'read']) }}" 
                   class="px-3 py-1.5 rounded-xl transition {{ request('status') === 'read' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Read
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'in_progress']) }}" 
                   class="px-3 py-1.5 rounded-xl transition {{ request('status') === 'in_progress' ? 'bg-amber-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    In Progress
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'resolved']) }}" 
                   class="px-3 py-1.5 rounded-xl transition {{ request('status') === 'resolved' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Resolved
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between gap-4">
            <form action="{{ route('admin.inquiries.index') }}" method="GET" class="flex-1 max-w-md relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, subject, or message content..."
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <div class="absolute left-3 top-2.5 text-slate-400">
                    <x-icon name="search" class="w-3.5 h-3.5" />
                </div>
            </form>
            <div class="text-xs font-semibold text-slate-500">
                Total: {{ $inquiries->total() }} records
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-6">Client / Prospect</th>
                            <th class="py-3.5 px-6">Subject / Service</th>
                            <th class="py-3.5 px-6">Message Excerpt</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Received</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($inquiries as $inq)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <span>{{ $inq->name }}</span>
                                        @if($inq->status === 'new')
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        @endif
                                    </div>
                                    <div class="text-slate-500 text-[11px]">{{ $inq->email }}</div>
                                    @if($inq->phone)
                                        <div class="text-slate-400 text-[10px]">{{ $inq->phone }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-800">{{ $inq->subject ?? 'Inquiry' }}</div>
                                    @if($inq->service_interested)
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700">
                                            {{ $inq->service_interested }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 max-w-xs truncate text-slate-500">
                                    {{ $inq->message }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($inq->status === 'new')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">New</span>
                                    @elseif($inq->status === 'read')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200">Read</span>
                                    @elseif($inq->status === 'in_progress')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">In Progress</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Resolved</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-slate-400 text-[11px]">
                                    {{ $inq->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition">
                                            Open
                                        </a>
                                        <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Delete">
                                                <x-icon name="trash" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400">
                                    No customer inquiries matching this filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $inquiries->links() }}
            </div>
        </div>
    </div>
@endsection

