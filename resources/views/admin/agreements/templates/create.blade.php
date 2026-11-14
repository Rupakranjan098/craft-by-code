@extends('layouts.admin')

@section('title', 'Create Agreement Template')
@section('header_title', 'Create Template')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.templates.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Templates</span>
        </a>
    </div>

    <!-- Form Box -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">New Contract Template</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Create boilerplate clauses, milestone templates, and legal terms.</p>
        </div>

        <form action="{{ route('admin.agreements.templates.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Template Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. AI Automation & SaaS Agreement"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Category *</label>
                    <select name="category" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="Software Development">Software Development</option>
                        <option value="MVP Development">MVP Development</option>
                        <option value="Maintenance & SLA">Maintenance & SLA</option>
                        <option value="Legal & Compliance">Legal & Compliance</option>
                        <option value="Consulting & Advisory">Consulting & Advisory</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Short Description</label>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Brief summary of when this template should be utilized..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Default Payment Terms (Optional)</label>
                    <textarea name="default_payment_terms" rows="2" placeholder="e.g. 50% mobilization deposit, 50% on delivery..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('default_payment_terms') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Template Legal Clauses &amp; Content *</label>
                    <textarea name="content" required rows="10" placeholder="Standard legal clauses..."
                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 leading-relaxed">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.agreements.templates.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-sm hover:shadow">
                    Save Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
