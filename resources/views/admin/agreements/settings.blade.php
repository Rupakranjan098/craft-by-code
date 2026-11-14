@extends('layouts.admin')

@section('title', 'Agreement Legal Settings')
@section('header_title', 'Agreement Settings')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Agreements Dashboard</span>
        </a>
    </div>

    <!-- Settings Box -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Legal Entity &amp; Contract Settings</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Configure default first-party identification, official corporate legal entity, authorized signatory, and compliance parameters.</p>
        </div>

        <form action="{{ route('admin.agreements.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">First Party Legal Entity Name *</label>
                    <input type="text" name="legal_entity_name" required value="{{ old('legal_entity_name', $settings['legal_entity_name']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Registered Corporate Address *</label>
                    <input type="text" name="legal_address" required value="{{ old('legal_address', $settings['legal_address']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Official Legal / Contract Email *</label>
                    <input type="email" name="legal_email" required value="{{ old('legal_email', $settings['legal_email']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Default Governing Jurisdiction *</label>
                    <input type="text" name="default_jurisdiction" required value="{{ old('default_jurisdiction', $settings['default_jurisdiction']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Default Authorized Signatory Name *</label>
                    <input type="text" name="signatory_name" required value="{{ old('signatory_name', $settings['signatory_name']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Signatory Title / Designation *</label>
                    <input type="text" name="signatory_title" required value="{{ old('signatory_title', $settings['signatory_title']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Legal Document Retention (Years) *</label>
                    <input type="number" min="1" max="30" name="retention_years" required value="{{ old('retention_years', $settings['retention_years']) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-sm hover:shadow">
                    Save Legal Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

