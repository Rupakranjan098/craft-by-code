@extends('layouts.admin')

@section('title', 'Inquiry from ' . $inquiry->name)
@section('header_title', 'Inquiry Details')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Inquiries</span>
            </a>

            <div class="flex items-center gap-2">
                <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: ' . ($inquiry->subject ?? 'Your Inquiry to UpPage Technology')) }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                    <x-icon name="mail" class="w-4 h-4" />
                    <span>Reply via Email</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left 8 cols: Client Message Body -->
            <div class="lg:col-span-8 bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">
                            {{ $inquiry->service_interested ?? 'General Inquiry' }}
                        </span>
                        <span class="text-xs text-slate-400">
                            {{ $inquiry->created_at->format('M d, Y \a\t h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $inquiry->subject ?? 'Project Inquiry' }}
                    </h2>
                </div>

                <!-- Client Details Strip -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Prospect Name</span>
                        <span class="font-bold text-slate-900">{{ $inquiry->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Email Address</span>
                        <a href="mailto:{{ $inquiry->email }}" class="font-bold text-blue-600 hover:underline">{{ $inquiry->email }}</a>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Phone Number</span>
                        <span class="font-bold text-slate-900">{{ $inquiry->phone ?? 'Not provided' }}</span>
                    </div>
                </div>

                <!-- Message Box -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Project Brief & Message Content</h3>
                    <div class="p-6 rounded-2xl bg-slate-50/60 border border-slate-200/60 text-slate-800 text-sm leading-relaxed whitespace-pre-wrap font-sans">
                        {{ $inquiry->message }}
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 pt-2 flex items-center justify-between">
                    <span>Sender IP: {{ $inquiry->ip_address ?? '127.0.0.1' }}</span>
                    <span>Database ID: #{{ $inquiry->id }}</span>
                </div>
            </div>

            <!-- Right 4 cols: Status Management & Admin Notes -->
            <div class="lg:col-span-4 space-y-6">
                <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST" class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                    @csrf
                    @method('PUT')

                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Update Lead Status</h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>🔴 New (Unaddressed)</option>
                            <option value="read" {{ $inquiry->status === 'read' ? 'selected' : '' }}>🔵 Read (Reviewed)</option>
                            <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>🟡 In Progress (Contacted)</option>
                            <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>🟢 Resolved (Closed)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Internal Team Notes</label>
                        <textarea name="admin_notes" rows="4" placeholder="Log call notes, agreed budget, or follow-up milestones..."
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Save Status & Notes
                    </button>
                </form>

                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Permanently delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 text-xs font-bold rounded-xl transition border border-rose-200">
                        Delete Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

