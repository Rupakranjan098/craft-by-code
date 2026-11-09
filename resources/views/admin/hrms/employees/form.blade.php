@extends('layouts.admin')

@section('title', $employee->exists ? 'Edit Employee' : 'Onboard Employee')
@section('header_title', $employee->exists ? 'Edit Employee Profile' : 'New Employee Onboarding')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $employee->exists ? 'Update Employee: ' . $employee->name : 'Onboard New Employee' }}
            </h1>
            <p class="text-xs text-slate-500">Fill in the employee details, contract parameters, and department mapping</p>
        </div>
        <a href="{{ route('admin.hrms.employees.index') }}" 
           class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Employees</span>
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
            <div class="font-bold mb-1">Please correct the following errors:</div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $employee->exists ? route('admin.hrms.employees.update', $employee) : route('admin.hrms.employees.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-8">
        @csrf
        @if($employee->exists)
            @method('PUT')
        @endif

        <!-- General Info Section -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span>Personal & Identification Details</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Employee ID -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Employee ID <span class="text-rose-500">*</span></label>
                    <input type="text" name="employee_id" 
                           value="{{ old('employee_id', $employee->employee_id ?? ('UPP-' . str_pad(\App\Models\Employee::count() + 1, 3, '0', STR_PAD_LEFT))) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <p class="text-[11px] text-slate-400 mt-1">Unique company code, e.g. UPP-001</p>
                </div>

                <!-- Full Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" 
                           value="{{ old('name', $employee->name) }}" 
                           required placeholder="e.g. John Doe"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Email Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Official Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" 
                           value="{{ old('email', $employee->email) }}" 
                           required placeholder="john@uppage.tech"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number</label>
                    <input type="text" name="phone" 
                           value="{{ old('phone', $employee->phone) }}" 
                           placeholder="+91 98765 43210"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>
        </div>

        <!-- Role & Employment Info -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                <span>Job Role & Compensation</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Department -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Assigned Department <span class="text-rose-500">*</span></label>
                    <select name="department_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }} ({{ $dept->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Designation -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Designation / Role Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="designation" 
                           value="{{ old('designation', $employee->designation) }}" 
                           required placeholder="e.g. Senior Full-Stack Developer"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Monthly Salary -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Monthly Base Salary (₹) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" name="salary" 
                           value="{{ old('salary', $employee->salary ?? 65000) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Joining Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Joining Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="joining_date" 
                           value="{{ old('joining_date', $employee->joining_date ? $employee->joining_date->format('Y-m-d') : date('Y-m-d')) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Employment Status <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="active" {{ old('status', $employee->status ?? 'active') === 'active' ? 'selected' : '' }}>Active Staff</option>
                        <option value="on_leave" {{ old('status', $employee->status) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="terminated" {{ old('status', $employee->status) === 'terminated' ? 'selected' : '' }}>Terminated / Relieved</option>
                    </select>
                </div>

                <!-- Emergency Contact -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Emergency Contact Details</label>
                    <input type="text" name="emergency_contact" 
                           value="{{ old('emergency_contact', $employee->emergency_contact) }}" 
                           placeholder="Spouse / Parent: +91 99999 88888"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>
        </div>

        <!-- Additional Information & Avatar -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                <span>Address & Profile Photo</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Residential Address</label>
                    <textarea name="address" rows="3" placeholder="Plot No. 12, Tech Zone, Bhubaneswar, Odisha"
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('address', $employee->address) }}</textarea>
                </div>

                <!-- Avatar Upload -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Profile Photo / Avatar</label>
                    <div class="flex items-center gap-4">
                        @if($employee->avatar)
                            <img src="{{ asset($employee->avatar) }}" alt="Avatar" class="w-14 h-14 rounded-2xl object-cover border border-slate-200">
                        @else
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                        @endif
                        <input type="file" name="avatar_file" accept="image/*"
                               class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">Optional. JPG or PNG under 2MB. Default team avatar used if blank.</p>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.hrms.employees.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow-md">
                {{ $employee->exists ? 'Save Changes' : 'Complete Onboarding' }}
            </button>
        </div>
    </form>
</div>
@endsection

