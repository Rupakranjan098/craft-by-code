@extends('layouts.admin')

@section('title', 'Leave Management')
@section('header_title', 'HRMS • Leave Applications')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Leave Applications & Approvals</h1>
            <p class="text-xs text-slate-500">Review time-off requests, sick leaves, and personal absences</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hrms.dashboard') }}" 
               class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>HRMS Hub</span>
            </a>
        </div>
    </div>

    <!-- Filter Status Tabs -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.hrms.leaves.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('status') || request('status') === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                All Requests
            </a>
            <a href="{{ route('admin.hrms.leaves.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-slate-950 shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Pending ({{ \App\Models\Leave::where('status', 'pending')->count() }})
            </a>
            <a href="{{ route('admin.hrms.leaves.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Approved
            </a>
            <a href="{{ route('admin.hrms.leaves.index', ['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Rejected
            </a>
        </div>

        <div class="text-xs font-semibold text-slate-500">
            Total {{ $leaves->total() }} records
        </div>
    </div>

    <!-- Leaves List -->
    <div class="space-y-4">
        @forelse($leaves as $leave)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-slate-300 transition">
                <!-- Employee & Leave Details -->
                <div class="space-y-3 flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <img src="{{ asset($leave->employee->avatar ?? 'assets/images/team/team-1.jpg') }}" 
                             alt="{{ $leave->employee->name }}" 
                             class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm">{{ $leave->employee->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $leave->employee->employee_id }}</span>
                            </div>
                            <div class="text-[11px] text-slate-500">
                                {{ $leave->employee->designation }} • <span class="text-slate-700 font-semibold">{{ $leave->employee->department->name ?? 'General' }}</span>
                            </div>
                        </div>

                        <!-- Leave Type Badge -->
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            {{ ucfirst($leave->leave_type) }} Leave
                        </span>

                        <!-- Status Badge -->
                        @if($leave->status === 'approved')
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                            </span>
                        @elseif($leave->status === 'rejected')
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                            </span>
                        @endif
                    </div>

                    <!-- Leave Duration & Reason -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Time Period</span>
                            <div class="text-xs font-bold text-slate-900">
                                {{ $leave->start_date->format('M d, Y') }} — {{ $leave->end_date->format('M d, Y') }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 font-semibold">
                                Duration: {{ $leave->days_count }} {{ Str::plural('working day', $leave->days_count) }}
                            </div>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Employee Reason</span>
                            <p class="text-xs text-slate-700 italic">"{{ $leave->reason }}"</p>
                        </div>
                    </div>

                    @if($leave->admin_remarks)
                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5 pt-1">
                            <span class="font-bold text-slate-700">Manager Remarks:</span>
                            <span>{{ $leave->admin_remarks }}</span>
                        </div>
                    @endif
                </div>

                <!-- Admin Action Controls -->
                <div class="md:w-64 pt-4 md:pt-0 md:border-l md:border-slate-100 md:pl-6 flex flex-col justify-center">
                    <form action="{{ route('admin.hrms.leaves.status', $leave) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Update Status:</label>
                            <select name="status" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900">
                                <option value="approved" {{ $leave->status === 'approved' ? 'selected' : '' }}>Approve Request</option>
                                <option value="rejected" {{ $leave->status === 'rejected' ? 'selected' : '' }}>Reject Request</option>
                            </select>
                        </div>

                        <div>
                            <input type="text" name="admin_remarks" value="{{ $leave->admin_remarks }}" placeholder="Add remark..."
                                   class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700">
                        </div>

                        <button type="submit" class="w-full py-2 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs transition">
                            Save Status
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-12 text-center text-slate-400">
                No leave requests found for this status.
            </div>
        @endforelse
    </div>

    @if($leaves->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200">
            {{ $leaves->links() }}
        </div>
    @endif
</div>
@endsection

