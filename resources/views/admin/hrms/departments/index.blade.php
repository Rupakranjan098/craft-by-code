@extends('layouts.admin')

@section('title', 'Manage Departments')
@section('header_title', 'HRMS • Departments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Organizational Departments</h1>
            <p class="text-xs text-slate-500">Configure organizational units, department heads, and team staffing</p>
        </div>
        <a href="{{ route('admin.hrms.dashboard') }}" 
           class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-2 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>HRMS Hub</span>
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Departments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Active Departments</h2>
                        <p class="text-xs text-slate-500">Total of {{ $departments->count() }} business divisions</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-6">Dept Code</th>
                                <th class="py-3 px-6">Department Name</th>
                                <th class="py-3 px-6">Manager / Lead</th>
                                <th class="py-3 px-6">Staff Count</th>
                                <th class="py-3 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($departments as $dept)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200/60">
                                            {{ $dept->code }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-900 text-sm">{{ $dept->name }}</div>
                                        @if($dept->description)
                                            <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $dept->description }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-700">
                                        {{ $dept->manager_name ?? 'Not Assigned' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('admin.hrms.employees.index', ['department_id' => $dept->id]) }}" 
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 hover:bg-blue-100 text-slate-700 hover:text-blue-700 transition">
                                            <span>{{ $dept->employees_count }}</span>
                                            <span class="text-[10px] font-normal">staff</span>
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if($dept->employees_count > 0)
                                            <span class="text-[10px] font-semibold text-slate-400" title="Cannot delete department with active employees">
                                                Locked (In Use)
                                            </span>
                                        @else
                                            <form action="{{ route('admin.hrms.departments.destroy', $dept) }}" method="POST" 
                                                  onsubmit="return confirm('Remove department {{ $dept->name }}?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete Department">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">
                                        No departments found. Add one on the right.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Department Form (1 col) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <x-icon name="plus" class="w-4 h-4" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Add New Department</h2>
                        <p class="text-[11px] text-slate-400">Expand organizational structure</p>
                    </div>
                </div>

                <form action="{{ route('admin.hrms.departments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Department Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. AI & Machine Learning"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Code / Abbreviation <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" required placeholder="e.g. AI-ML"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Department Manager / Lead</label>
                        <input type="text" name="manager_name" placeholder="e.g. Vikram Patel"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Brief notes on responsibilities..."
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow-md">
                        Create Department
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

