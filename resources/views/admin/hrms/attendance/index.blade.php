@extends('layouts.admin')

@section('title', 'Attendance Management')
@section('header_title', 'HRMS • Daily Attendance Logs')

@section('content')
<div class="space-y-6">
    <!-- Header with Date Selection -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Attendance Registry</h1>
            <p class="text-xs text-slate-500">Log, review, and adjust staff daily check-ins and hours</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hrms.dashboard') }}" 
               class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>HRMS Hub</span>
            </a>
        </div>
    </div>

    <!-- Date Navigator & Quick Stats -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <form action="{{ route('admin.hrms.attendance.index') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
            <label class="text-xs font-bold text-slate-700">Date:</label>
            <input type="date" name="date" value="{{ $date }}" 
                   class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition">
                Load Date
            </button>
            <a href="{{ route('admin.hrms.attendance.index', ['date' => now()->toDateString()]) }}" 
               class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                Today
            </a>
        </form>

        <!-- Stats Chips -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
            <div class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-bold text-emerald-800">{{ $stats['present'] }} Present</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span class="text-xs font-bold text-amber-800">{{ $stats['late'] }} Late</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span class="text-xs font-bold text-rose-800">{{ $stats['absent'] }} Absent</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-purple-50 border border-purple-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                <span class="text-xs font-bold text-purple-800">{{ $stats['on_leave'] }} On Leave</span>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Attendance Log for {{ \Carbon\Carbon::parse($date)->format('F d, Y (l)') }}</h2>
                <p class="text-xs text-slate-500">Record check-in time, check-out time, and status for each employee</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Employee</th>
                        <th class="py-3.5 px-6">Department</th>
                        <th class="py-3.5 px-6">Current Status</th>
                        <th class="py-3.5 px-6">Check In</th>
                        <th class="py-3.5 px-6">Check Out</th>
                        <th class="py-3.5 px-6">Notes / Remarks</th>
                        <th class="py-3.5 px-6 text-right">Update Record</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($employees as $emp)
                        @php
                            $att = $emp->attendances->first();
                            $status = $att->status ?? 'absent';
                            $checkIn = $att && $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('H:i') : '';
                            $checkOut = $att && $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '';
                            $notes = $att->notes ?? '';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($emp->avatar ?? 'assets/images/team/team-1.jpg') }}" 
                                         alt="{{ $emp->name }}" 
                                         class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $emp->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $emp->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $emp->department->name ?? 'General' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($att)
                                    @if($status === 'present')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Present
                                        </span>
                                    @elseif($status === 'late')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Late
                                        </span>
                                    @elseif($status === 'half_day')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Half Day
                                        </span>
                                    @elseif($status === 'on_leave')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> On Leave
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Absent
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                        Not Marked
                                    </span>
                                @endif
                            </td>

                            <!-- Inline Form for Fast Attendance Editing -->
                            <form action="{{ route('admin.hrms.attendance.mark') }}" method="POST">
                                @csrf
                                <input type="hidden" name="employee_id" value="{{ $emp->id }}">
                                <input type="hidden" name="date" value="{{ $date }}">

                                <td class="py-4 px-6">
                                    <input type="time" name="check_in" value="{{ $checkIn }}" 
                                           class="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600">
                                </td>
                                <td class="py-4 px-6">
                                    <input type="time" name="check_out" value="{{ $checkOut }}" 
                                           class="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-600">
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <select name="status" class="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800">
                                            <option value="present" {{ $status === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="late" {{ $status === 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="half_day" {{ $status === 'half_day' ? 'selected' : '' }}>Half Day</option>
                                            <option value="absent" {{ $status === 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="on_leave" {{ $status === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                        </select>
                                        <input type="text" name="notes" value="{{ $notes }}" placeholder="Notes..."
                                               class="w-28 px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-[11px] text-slate-700">
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <button type="submit" class="px-3 py-1 bg-slate-900 hover:bg-blue-600 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                        Save
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                No active employees found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

