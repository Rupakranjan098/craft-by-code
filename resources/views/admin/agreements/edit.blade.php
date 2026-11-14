@extends('layouts.admin')

@section('title', 'Edit Agreement ' . $agreement->agreement_number)
@section('header_title', 'Edit Agreement')

@section('content')
<div class="max-w-5xl space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.show', $agreement->id) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Agreement Details</span>
        </a>

        <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
            {{ $agreement->agreement_number }}
        </span>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Agreement Terms</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Modify contracting details, commercial milestones, and legal content. Modifications are tracked in the audit trail.</p>
        </div>

        <form action="{{ route('admin.agreements.update', $agreement->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Client / Second Party Information -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">1</span>
                    <span>Client / Second Party Information</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Full Name *</label>
                        <input type="text" name="client_name" required value="{{ old('client_name', $agreement->client_name) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Work Email *</label>
                        <input type="email" name="client_email" required value="{{ old('client_email', $agreement->client_email) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Company Name</label>
                        <input type="text" name="client_company" value="{{ old('client_company', $agreement->client_company) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Phone Number</label>
                        <input type="text" name="client_phone" value="{{ old('client_phone', $agreement->client_phone) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Registered Address</label>
                        <input type="text" name="client_address" value="{{ old('client_address', $agreement->client_address) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- 2. Contract Parameters & Commercials -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">2</span>
                    <span>Commercial Terms &amp; Scope</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Agreement Title *</label>
                        <input type="text" name="title" required value="{{ old('title', $agreement->title) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Contract Value *</label>
                        <input type="number" step="0.01" min="0" name="contract_value" required value="{{ old('contract_value', $agreement->contract_value) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Currency *</label>
                        <select name="currency" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="USD" {{ old('currency', $agreement->currency) === 'USD' ? 'selected' : '' }}>USD ($ - US Dollar)</option>
                            <option value="EUR" {{ old('currency', $agreement->currency) === 'EUR' ? 'selected' : '' }}>EUR (€ - Euro)</option>
                            <option value="GBP" {{ old('currency', $agreement->currency) === 'GBP' ? 'selected' : '' }}>GBP (£ - British Pound)</option>
                            <option value="INR" {{ old('currency', $agreement->currency) === 'INR' ? 'selected' : '' }}>INR (₹ - Indian Rupee)</option>
                            <option value="CAD" {{ old('currency', $agreement->currency) === 'CAD' ? 'selected' : '' }}>CAD (C$ - Canadian Dollar)</option>
                            <option value="AUD" {{ old('currency', $agreement->currency) === 'AUD' ? 'selected' : '' }}>AUD (A$ - Australian Dollar)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $agreement->start_date ? $agreement->start_date->format('Y-m-d') : '') }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Scope of Work (Schedule A)</label>
                        <textarea name="scope_of_work" rows="3"
                                  class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('scope_of_work', $agreement->scope_of_work) }}</textarea>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Payment Terms (Schedule B)</label>
                        <textarea name="payment_terms" rows="3"
                                  class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('payment_terms', $agreement->payment_terms) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3. Legal Clauses -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">3</span>
                    <span>Legal Terms, Clauses &amp; Covenants *</span>
                </h3>

                <div>
                    <textarea name="content" required rows="12"
                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 leading-relaxed">{{ old('content', $agreement->content) }}</textarea>
                </div>
            </div>

            <!-- Action Strip -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.agreements.show', $agreement->id) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-md hover:shadow-lg">
                    Update Agreement &amp; Recompile PDF &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

