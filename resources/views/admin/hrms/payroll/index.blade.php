@extends('layouts.admin')

@section('title', 'Payroll Management')
@section('header_title', 'HRMS • Payroll & Compensation')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Salaries & Payroll Management</h1>
            <p class="text-xs text-slate-500">Generate, adjust, and disburse employee monthly compensation and generate payslips</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hrms.dashboard') }}" 
               class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>HRMS Hub</span>
            </a>
        </div>
    </div>

    <!-- Month Selector & KPI Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <!-- Month Picker -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-slate-500 mb-2">Pay Period / Month</span>
            <form action="{{ route('admin.hrms.payroll.index') }}" method="GET" class="space-y-2">
                <select name="month" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @foreach([now()->format('F Y'), now()->subMonth()->format('F Y'), now()->subMonths(2)->format('F Y'), now()->addMonth()->format('F Y')] as $m)
                        <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
                <div class="text-[10px] text-slate-400">Cycle: 1st - End of Month</div>
            </form>
        </div>

        <!-- Disbursed Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-bold text-slate-500">Disbursed (Paid)</span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-2xl font-black text-emerald-600">₹{{ number_format($totalDisbursed) }}</div>
            <div class="text-[11px] text-slate-400">Total transferred to staff</div>
        </div>

        <!-- Pending Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-bold text-slate-500">Pending Approval</span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-2xl font-black text-amber-600">₹{{ number_format($totalPending) }}</div>
            <div class="text-[11px] text-slate-400">Pending clearance</div>
        </div>

        <!-- Total Payroll -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-bold text-slate-500">Total Month Budget</span>
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            </div>
            <div class="text-2xl font-black text-slate-900">₹{{ number_format($totalDisbursed + $totalPending) }}</div>
            <div class="text-[11px] text-slate-400">{{ $payrolls->count() }} enrolled employees</div>
        </div>
    </div>

    <!-- Payroll Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Payroll Records for {{ $month }}</h2>
                <p class="text-xs text-slate-500">Salary breakdown, allowances, taxes, deductions and payslip access</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Employee</th>
                        <th class="py-3.5 px-6">Basic Salary</th>
                        <th class="py-3.5 px-6">Allowances</th>
                        <th class="py-3.5 px-6">Deductions</th>
                        <th class="py-3.5 px-6">Net Salary</th>
                        <th class="py-3.5 px-6">Payment Info</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($payrolls as $pr)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($pr->employee->avatar ?? 'assets/images/team/team-1.jpg') }}" 
                                         alt="{{ $pr->employee->name }}" 
                                         class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs">{{ $pr->employee->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $pr->employee->employee_id }} • {{ $pr->employee->designation }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">
                                ₹{{ number_format($pr->basic_salary) }}
                            </td>
                            <td class="py-4 px-6 text-emerald-600 font-semibold">
                                +₹{{ number_format($pr->allowances) }}
                            </td>
                            <td class="py-4 px-6 text-rose-600 font-semibold">
                                -₹{{ number_format($pr->deductions) }}
                            </td>
                            <td class="py-4 px-6 font-extrabold text-sm text-slate-900">
                                ₹{{ number_format($pr->net_salary) }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-[11px] font-semibold text-slate-700">{{ $pr->payment_method ?? 'Direct Bank' }}</div>
                                <div class="text-[10px] text-slate-400">
                                    {{ $pr->payment_date ? \Carbon\Carbon::parse($pr->payment_date)->format('d M, Y') : 'Unscheduled' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($pr->status === 'paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disbursed
                                    </span>
                                @elseif($pr->status === 'processed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Processed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Payslip Button -->
                                    <a href="{{ route('admin.hrms.payroll.payslip', $pr) }}" 
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-[11px] font-bold transition flex items-center gap-1"
                                       title="View Official Payslip">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        <span>Payslip</span>
                                    </a>

                                    <!-- Quick Status Toggle -->
                                    <form action="{{ route('admin.hrms.payroll.status', $pr) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        @if($pr->status !== 'paid')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold transition shadow-sm">
                                                Mark Paid
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="px-2 py-1 rounded text-[10px] text-slate-400 hover:text-slate-600 transition" title="Revert to pending">
                                                Reset
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                No payroll records found for {{ $month }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

