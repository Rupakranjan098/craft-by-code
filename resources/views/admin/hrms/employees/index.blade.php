@extends('layouts.admin')

@section('title', 'Manage Employees')
@section('header_title', 'HRMS • Employee Directory')

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Staff & Employee Directory</h1>
            <p class="text-xs text-slate-500">Manage all internal engineers, designers, project leads and payroll data</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hrms.dashboard') }}" 
               class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>HRMS Hub</span>
            </a>
            <a href="{{ route('admin.hrms.employees.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                <x-icon name="plus" class="w-4 h-4" />
                <span>Onboard Employee</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.hrms.employees.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-1">
                <div class="relative flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, email, role..."
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <div class="absolute left-3 top-2.5 text-slate-400">
                        <x-icon name="search" class="w-3.5 h-3.5" />
                    </div>
                </div>

                <select name="department_id" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="on_leave" {{ request('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                    Filter
                </button>

                @if(request()->anyFilled(['search', 'department_id', 'status']))
                    <a href="{{ route('admin.hrms.employees.index') }}" class="px-3 py-2 text-xs font-bold text-rose-600 hover:underline">
                        Reset
                    </a>
                @endif
            </div>

            <div class="text-xs font-semibold text-slate-500 whitespace-nowrap">
                Total: <span class="font-bold text-slate-900">{{ $employees->total() }}</span> employees
            </div>
        </form>
    </div>

    <!-- Employees Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Emp ID</th>
                        <th class="py-3.5 px-6">Employee</th>
                        <th class="py-3.5 px-6">Department</th>
                        <th class="py-3.5 px-6">Designation</th>
                        <th class="py-3.5 px-6">Monthly Salary</th>
                        <th class="py-3.5 px-6">Joining Date</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600 text-xs">
                                {{ $emp->employee_id }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($emp->avatar ?? 'assets/images/team/team-1.jpg') }}" 
                                         alt="{{ $emp->name }}" 
                                         class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-sm">
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs">{{ $emp->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $emp->email }}</div>
                                        @if($emp->phone)
                                            <div class="text-[10px] text-slate-400">{{ $emp->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $emp->department->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $emp->designation }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                ₹{{ number_format($emp->salary) }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 font-mono">
                                {{ $emp->joining_date->format('d M, Y') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($emp->status === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @elseif($emp->status === 'on_leave')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> On Leave
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Terminated
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.hrms.employees.edit', $emp) }}" 
                                   class="inline-block p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Employee">
                                    <x-icon name="edit" class="w-4 h-4" />
                                </a>
                                <form action="{{ route('admin.hrms.employees.destroy', $emp) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete employee record {{ $emp->name }}? This will also remove associated attendances and payslips.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete Employee">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                No employees found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

