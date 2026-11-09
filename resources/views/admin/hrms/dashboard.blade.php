@extends('layouts.admin')

@section('title', 'HRMS Dashboard')
@section('header_title', 'HRMS & Staff Management')

@section('content')
<div class="space-y-8">
    <!-- Top HRMS Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#080D19] via-indigo-950 to-blue-900 p-8 text-white shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-blue-500/20 text-blue-300 border border-blue-400/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Admin Enterprise Suite • HRMS Active</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight mb-2">
                    Human Resource & Workforce Center
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                    Centrally oversee employee records, daily attendance tracking, department assignments, leave approvals, and monthly salary disbursement.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.hrms.employees.create') }}" 
                   class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    <span>Onboard Employee</span>
                </a>
                <a href="{{ route('admin.hrms.attendance.index') }}" 
                   class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition border border-white/10 flex items-center gap-2">
                    <x-icon name="clock" class="w-4 h-4" />
                    <span>Log Attendance</span>
                </a>
                <a href="{{ route('admin.hrms.payroll.index') }}" 
                   class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    <span>Payroll</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 6 Metric Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Total Employees -->
        <a href="{{ route('admin.hrms.employees.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Employees</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $totalEmployees }}</div>
            <div class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>{{ $activeEmployees }} active</span>
            </div>
        </a>

        <!-- Today's Attendance -->
        <a href="{{ route('admin.hrms.attendance.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Attendance</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <x-icon name="clock" class="w-4 h-4" />
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $attendanceRate }}%</div>
            <div class="text-[11px] font-semibold text-slate-500 mt-1">
                {{ $todayPresent }} of {{ $totalEmployees }} present
            </div>
        </a>

        <!-- On Leave Today -->
        <a href="{{ route('admin.hrms.leaves.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-amber-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">On Leave</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $onLeaveEmployees }}</div>
            <div class="text-[11px] font-semibold text-amber-600 mt-1">
                {{ $pendingLeaves->count() }} pending approval
            </div>
        </a>

        <!-- Departments -->
        <a href="{{ route('admin.hrms.departments.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-purple-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Departments</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <x-icon name="building" class="w-4 h-4" />
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $totalDepartments }}</div>
            <div class="text-[11px] font-semibold text-slate-500 mt-1">Engineering, Design, AI...</div>
        </a>

        <!-- Pending Leaves -->
        <a href="{{ route('admin.hrms.leaves.index', ['status' => 'pending']) }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-rose-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Leave Requests</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $pendingLeaves->count() }}</div>
            <div class="text-[11px] font-semibold text-rose-500 mt-1">Requires review</div>
        </a>

        <!-- Monthly Payroll -->
        <a href="{{ route('admin.hrms.payroll.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:border-indigo-400 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Month Payroll</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>
            <div class="text-xl font-black text-slate-900">₹{{ number_format($monthlyPayroll) }}</div>
            <div class="text-[11px] font-semibold text-slate-400 mt-1">{{ now()->format('M Y') }} budget</div>
        </a>
    </div>

    <!-- Main 2-column Grid: Attendance & Pending Leaves -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Today's Live Attendance Feed (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Today's Staff Attendance ({{ now()->format('M d, Y') }})</h2>
                    <p class="text-xs text-slate-500">Live check-in times and status records for current working day</p>
                </div>
                <a href="{{ route('admin.hrms.attendance.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Manage All</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Employee</th>
                            <th class="py-3 px-6">Department</th>
                            <th class="py-3 px-6">Check In</th>
                            <th class="py-3 px-6">Check Out</th>
                            <th class="py-3 px-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($todayAttendances as $att)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset($att->employee->avatar ?? 'assets/images/team/team-1.jpg') }}" 
                                             alt="{{ $att->employee->name }}" 
                                             class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm">
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $att->employee->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono">{{ $att->employee->employee_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                        {{ $att->employee->department->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-slate-700 font-mono">
                                    {{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i A') : '—' }}
                                </td>
                                <td class="py-3.5 px-6 text-slate-700 font-mono">
                                    {{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : '—' }}
                                </td>
                                <td class="py-3.5 px-6">
                                    @if($att->status === 'present')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Present
                                        </span>
                                    @elseif($att->status === 'late')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Late
                                        </span>
                                    @elseif($att->status === 'on_leave')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> On Leave
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> {{ ucfirst($att->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    No attendance logged for today yet.
                                    <div class="mt-2">
                                        <a href="{{ route('admin.hrms.attendance.index') }}" class="text-blue-600 font-bold underline">Mark Today's Attendance</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Leave Approvals (1 col) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Pending Leaves</h2>
                    <p class="text-xs text-slate-500">Requests requiring management action</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">
                    {{ $pendingLeaves->count() }} Pending
                </span>
            </div>

            <div class="p-6 divide-y divide-slate-100 flex-1 space-y-4">
                @forelse($pendingLeaves as $leave)
                    <div class="pt-4 first:pt-0">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="font-bold text-slate-900 text-xs">{{ $leave->employee->name }}</div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">
                                {{ ucfirst($leave->leave_type) }}
                            </span>
                        </div>
                        <div class="text-[11px] text-slate-500 mb-2">
                            {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }} 
                            <span class="font-semibold text-slate-700">({{ $leave->days_count }} {{ Str::plural('day', $leave->days_count) }})</span>
                        </div>
                        <p class="text-xs text-slate-600 italic bg-slate-50 p-2.5 rounded-xl border border-slate-100 mb-3">
                            "{{ $leave->reason }}"
                        </p>

                        <!-- Instant Action Buttons -->
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.hrms.leaves.status', $leave) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <input type="hidden" name="admin_remarks" value="Approved via HRMS Dashboard">
                                <button type="submit" class="w-full py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] transition">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.hrms.leaves.status', $leave) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <input type="hidden" name="admin_remarks" value="Declined due to scheduling constraints">
                                <button type="submit" class="w-full py-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-[11px] transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400">
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
                        </div>
                        <p class="text-xs">All leave requests have been reviewed!</p>
                    </div>
                @endforelse
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 rounded-b-3xl text-center">
                <a href="{{ route('admin.hrms.leaves.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                    View Complete Leave History →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Team Additions -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Recent Employee Profiles</h2>
                <p class="text-xs text-slate-500">Newly added talent and active staff records</p>
            </div>
            <a href="{{ route('admin.hrms.employees.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                <span>View All Employees ({{ $totalEmployees }})</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($recentEmployees as $emp)
                <div class="p-4 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:shadow-md transition bg-gradient-to-b from-white to-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-mono text-slate-400 font-bold">{{ $emp->employee_id }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $emp->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ ucfirst($emp->status) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ asset($emp->avatar ?? 'assets/images/team/team-1.jpg') }}" alt="{{ $emp->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                            <div>
                                <h3 class="font-bold text-slate-900 text-xs">{{ $emp->name }}</h3>
                                <div class="text-[11px] text-blue-600 font-semibold">{{ $emp->designation }}</div>
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-500 mb-1">
                            <span class="font-bold text-slate-700">Dept:</span> {{ $emp->department->name ?? 'General' }}
                        </div>
                        <div class="text-[11px] text-slate-500">
                            <span class="font-bold text-slate-700">Salary:</span> ₹{{ number_format($emp->salary) }}/mo
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] text-slate-400">Joined {{ $emp->joining_date->format('M Y') }}</span>
                        <a href="{{ route('admin.hrms.employees.edit', $emp) }}" class="text-[11px] font-bold text-blue-600 hover:underline">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

