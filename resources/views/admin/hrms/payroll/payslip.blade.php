@extends('layouts.admin')

@section('title', 'Payslip - ' . $payroll->employee->name . ' (' . $payroll->month . ')')
@section('header_title', 'HRMS • Salary Payslip')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action Bar (Hidden on print) -->
    <div class="flex items-center justify-between print:hidden">
        <a href="{{ route('admin.hrms.payroll.index') }}" 
           class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Payroll</span>
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" 
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                <span>Print Payslip</span>
            </button>
        </div>
    </div>

    <!-- Printable Payslip Document -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-lg p-8 sm:p-12 print:shadow-none print:border-none print:p-0 text-slate-800">
        <!-- Payslip Header -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b-2 border-slate-100">
            <div>
                <x-logo size="md" />
                <div class="text-xs text-slate-500 mt-3 space-y-0.5">
                    <p class="font-bold text-slate-700">{{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }}</p>
                    <p>{{ \App\Models\WebsiteSetting::get('contact_address', 'Tech Park Avenue, Infocity, Bhubaneswar, India') }}</p>
                    <p>Email: <a href="mailto:{{ \App\Models\WebsiteSetting::get('contact_email', 'hello@craftbycode.tech') }}" class="text-blue-600">{{ \App\Models\WebsiteSetting::get('contact_email', 'hello@craftbycode.tech') }}</a></p>
                </div>
            </div>

            <div class="sm:text-right">
                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                    Official Salary Slip
                </span>
                <div class="text-2xl font-black text-slate-900 mt-3 font-mono">
                    {{ $payroll->month }}
                </div>
                <div class="text-xs text-slate-500 mt-1">
                    Payslip Ref: <span class="font-mono font-bold text-slate-700">SLIP-{{ $payroll->id }}-{{ strtoupper(substr(md5($payroll->id . $payroll->month), 0, 6)) }}</span>
                </div>
                <div class="text-xs text-slate-500">
                    Disbursed: <span class="font-semibold text-slate-700">{{ $payroll->payment_date ? \Carbon\Carbon::parse($payroll->payment_date)->format('F d, Y') : 'Processing' }}</span>
                </div>
            </div>
        </div>

        <!-- Employee Info Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-8 border-b border-slate-100 text-xs">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Employee Name</span>
                <div class="font-black text-slate-900 text-sm">{{ $payroll->employee->name }}</div>
                <div class="text-slate-500 text-[11px] font-mono">{{ $payroll->employee->employee_id }}</div>
            </div>

            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Department / Role</span>
                <div class="font-bold text-slate-800">{{ $payroll->employee->department->name ?? 'Engineering' }}</div>
                <div class="text-slate-500 text-[11px]">{{ $payroll->employee->designation }}</div>
            </div>

            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Payment Method</span>
                <div class="font-bold text-slate-800">{{ $payroll->payment_method ?? 'Direct Bank Transfer' }}</div>
                <div class="text-emerald-600 font-semibold text-[11px] uppercase">{{ $payroll->status }}</div>
            </div>

            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Joining Date</span>
                <div class="font-bold text-slate-800">{{ $payroll->employee->joining_date->format('d M, Y') }}</div>
                <div class="text-slate-500 text-[11px]">{{ $payroll->employee->email }}</div>
            </div>
        </div>

        <!-- Earnings and Deductions Dual Tables -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-8 border-b border-slate-100">
            <!-- Earnings Table -->
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Earnings & Allowances</span>
                </h3>
                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">Basic Salary</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($payroll->basic_salary, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">House Rent Allowance (HRA)</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($payroll->allowances * 0.6, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">Special & Travel Allowance</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($payroll->allowances * 0.4, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-emerald-600 font-bold bg-emerald-50/50 px-2 rounded-lg">
                        <span>Total Earnings</span>
                        <span>₹{{ number_format($payroll->basic_salary + $payroll->allowances, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Deductions Table -->
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>Deductions & Taxes</span>
                </h3>
                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">Provident Fund (PF)</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($payroll->deductions * 0.5, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">Professional Tax & TDS</span>
                        <span class="font-bold text-slate-900">₹{{ number_format($payroll->deductions * 0.5, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-600">Other Deductions</span>
                        <span class="font-bold text-slate-900">₹0.00</span>
                    </div>
                    <div class="flex justify-between py-2 text-rose-600 font-bold bg-rose-50/50 px-2 rounded-lg">
                        <span>Total Deductions</span>
                        <span>-₹{{ number_format($payroll->deductions, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Payable Salary Banner -->
        <div class="my-8 p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs uppercase font-bold text-blue-300 tracking-wider block">Net Take-Home Salary</span>
                <span class="text-[11px] text-slate-300">Transferred to Employee bank account</span>
            </div>
            <div class="text-3xl font-black tracking-tight text-white font-mono">
                ₹{{ number_format($payroll->net_salary, 2) }}
            </div>
        </div>

        <!-- Signatures & Disclaimer Footer -->
        <div class="pt-8 grid grid-cols-2 gap-8 text-xs text-slate-500">
            <div>
                <div class="h-14 border-b border-dashed border-slate-300 mb-2"></div>
                <div class="font-bold text-slate-900">Employee Signature</div>
                <div class="text-[11px] text-slate-400">Date: {{ now()->format('d/m/Y') }}</div>
            </div>

            <div class="text-right">
                <div class="h-14 border-b border-dashed border-slate-300 mb-2 flex items-end justify-end">
                    <span class="text-[11px] font-mono text-blue-600 font-bold pb-1">{{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }} HR</span>
                </div>
                <div class="font-bold text-slate-900">Authorized Signatory</div>
                <div class="text-[11px] text-slate-400">{{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }} Operations</div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-slate-100 text-center text-[10px] text-slate-400">
            This payslip is a system-generated computer document from {{ \App\Models\WebsiteSetting::get('brand_name', 'craft by code') }} HRMS Suite. For queries contact {{ \App\Models\WebsiteSetting::get('contact_email', 'hr@craftbycode.tech') }}.
        </div>
    </div>
</div>
@endsection

