@extends('layouts.admin')

@section('title', 'Generate New Agreement')
@section('header_title', 'Create Agreement')

@section('content')
<div class="max-w-5xl space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            <span>Back to Agreements</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                Next Ref: {{ $nextNumber }}
            </span>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Generate Client Agreement</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Configure contracting parties, commercials, milestones, and legal clauses. Access is strictly Admin-only.</p>
        </div>

        <form action="{{ route('admin.agreements.store') }}" method="POST" class="space-y-8" id="agreement-form">
            @csrf

            <!-- 1. Template Selector (Optional Auto-Fill) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    Contract Template (Optional Preset)
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach($templates as $tpl)
                        <label class="relative p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-blue-500 cursor-pointer transition flex flex-col justify-between bg-slate-50/50 dark:bg-slate-950/40 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/40 dark:has-[:checked]:bg-blue-950/30">
                            <input type="radio" name="template_id" value="{{ $tpl->id }}" class="sr-only template-radio"
                                   data-title="{{ $tpl->name }}"
                                   data-content="{{ e($tpl->content) }}"
                                   data-payment="{{ e($tpl->default_payment_terms) }}"
                                   {{ (old('template_id') == $tpl->id || ($selectedTemplate && $selectedTemplate->id == $tpl->id)) ? 'checked' : '' }}>
                            <div>
                                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider block mb-1">{{ $tpl->category }}</span>
                                <span class="text-xs font-bold text-slate-900 dark:text-white block">{{ $tpl->name }}</span>
                            </div>
                            <p class="text-[10px] text-slate-400 line-clamp-2 mt-2">{{ $tpl->description }}</p>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 2. Client / Second Party Information -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">1</span>
                    <span>Client / Second Party Information</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Full Name *</label>
                        <input type="text" name="client_name" id="client_name" required value="{{ old('client_name') }}" placeholder="Alex Morgan"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Work Email *</label>
                        <input type="email" name="client_email" required value="{{ old('client_email') }}" placeholder="alex@company.com"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Company / Entity Name</label>
                        <input type="text" name="client_company" id="client_company" value="{{ old('client_company') }}" placeholder="Acme Technologies Inc"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Phone Number</label>
                        <input type="text" name="client_phone" value="{{ old('client_phone') }}" placeholder="+1 (555) 000-0000"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Client Registered Address</label>
                        <input type="text" name="client_address" value="{{ old('client_address') }}" placeholder="123 Financial Way, Suite 500, New York, NY 10001"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            <!-- 3. Contract Commercials & Parameters -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">2</span>
                    <span>Commercial Parameters &amp; Timeline</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Agreement Title *</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $selectedTemplate?->name ?? 'Master Software Development Agreement') }}" placeholder="e.g. Master Software Development Agreement"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Contract Value *</label>
                        <input type="number" step="0.01" min="0" name="contract_value" id="contract_value" required value="{{ old('contract_value', '25000.00') }}" placeholder="25000.00"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Currency *</label>
                        <select name="currency" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD ($ - US Dollar)</option>
                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (€ - Euro)</option>
                            <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP (£ - British Pound)</option>
                            <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR (₹ - Indian Rupee)</option>
                            <option value="CAD" {{ old('currency') === 'CAD' ? 'selected' : '' }}>CAD (C$ - Canadian Dollar)</option>
                            <option value="AUD" {{ old('currency') === 'AUD' ? 'selected' : '' }}>AUD (A$ - Australian Dollar)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Effective Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Scope of Work Schedule (Schedule A)</label>
                        <textarea name="scope_of_work" rows="3" placeholder="1. Frontend UI Architecture&#10;2. Microservices Backend &amp; Cloud Database&#10;3. Payment Gateway &amp; QA Verification"
                                  class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('scope_of_work') }}</textarea>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Payment Terms &amp; Milestones (Schedule B)</label>
                        <textarea name="payment_terms" id="payment_terms" rows="3" placeholder="Milestone terms..."
                                  class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('payment_terms', $selectedTemplate?->default_payment_terms) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Legal Clauses & Agreement Body -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-black">3</span>
                        <span>Legal Terms, Clauses &amp; Covenants *</span>
                    </h3>
                    <button type="button" id="replace-tokens-btn" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Apply Client Tokens to Clauses
                    </button>
                </div>

                <div>
                    <textarea name="content" id="content" required rows="12" placeholder="Full agreement legal clauses..."
                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 leading-relaxed">{{ old('content', $selectedTemplate?->content) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1.5">Supports tokens: <code class="font-mono text-blue-600">@{{CLIENT_NAME}}</code>, <code class="font-mono text-blue-600">@{{CLIENT_COMPANY}}</code>, <code class="font-mono text-blue-600">@{{CONTRACT_VALUE}}</code>, <code class="font-mono text-blue-600">@{{START_DATE}}</code></p>
                </div>
            </div>

            <!-- Submit Button Strip -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.agreements.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-md hover:shadow-lg">
                    Generate Agreement Document &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script nonce="{{ $cspNonce ?? '' }}">
    document.addEventListener('DOMContentLoaded', function () {
        const templateRadios = document.querySelectorAll('.template-radio');
        const titleInput = document.getElementById('title');
        const contentArea = document.getElementById('content');
        const paymentArea = document.getElementById('payment_terms');
        const replaceTokensBtn = document.getElementById('replace-tokens-btn');

        templateRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    const tTitle = this.getAttribute('data-title');
                    const tContent = this.getAttribute('data-content');
                    const tPayment = this.getAttribute('data-payment');
                    
                    if (titleInput && tTitle) titleInput.value = tTitle;
                    if (contentArea && tContent) contentArea.value = tContent;
                    if (paymentArea && tPayment) paymentArea.value = tPayment;
                }
            });
        });

        if (replaceTokensBtn && contentArea) {
            replaceTokensBtn.addEventListener('click', function () {
                const clientName = document.getElementById('client_name')?.value || 'Client Name';
                const clientCompany = document.getElementById('client_company')?.value || clientName;
                const contractValue = document.getElementById('contract_value')?.value || '0.00';
                const startDate = document.getElementById('start_date')?.value || '';
                
                let text = contentArea.value;
                text = text.replace(/\{\{CLIENT_NAME\}\}/g, clientName);
                text = text.replace(/\{\{CLIENT_COMPANY\}\}/g, clientCompany);
                text = text.replace(/\{\{CONTRACT_VALUE\}\}/g, '$' + contractValue);
                text = text.replace(/\{\{START_DATE\}\}/g, startDate);
                contentArea.value = text;
            });
        }
    });
</script>
@endpush
@endsection

