@extends('layouts.admin')

@section('title', 'Enterprise Security Center')
@section('header_title', 'Security Operations Center')

@section('content')
    <div class="space-y-8">
        <!-- Header & Quick Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Enterprise Security Center</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Real-time threat monitoring, IP blocking, API tokens, RBAC policies, and encrypted DB backups</p>
            </div>

            @if(Auth::user()?->hasPermission('backups.manage'))
                <form action="{{ route('admin.security.backup') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow">
                        Create Encrypted DB Backup Now
                    </button>
                </form>
            @endif
        </div>

        @if(session('new_api_token'))
            <div class="p-5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-700 space-y-2">
                <p class="text-xs font-bold text-emerald-800 dark:text-emerald-200">New Scoped Bearer Token Created (Copy Once):</p>
                <code class="block p-3 rounded-xl bg-white dark:bg-slate-900 border border-emerald-200 dark:border-slate-700 text-xs font-mono break-all text-slate-900 dark:text-emerald-300">{{ session('new_api_token') }}</code>
            </div>
        @endif

        <!-- Security Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <span class="text-xs font-bold text-slate-500 block mb-1">Failed Logins (24h)</span>
                <span class="text-2xl font-black text-slate-900">{{ $stats['failed_logins_24h'] }}</span>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <span class="text-xs font-bold text-slate-500 block mb-1">High/Critical Alerts (24h)</span>
                <span class="text-2xl font-black text-rose-600">{{ $stats['high_alerts_24h'] }}</span>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <span class="text-xs font-bold text-slate-500 block mb-1">Admin 2FA Adoption</span>
                <span class="text-2xl font-black text-emerald-600">{{ $stats['two_factor_enabled'] }} / {{ $stats['total_admins'] }}</span>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <span class="text-xs font-bold text-slate-500 block mb-1">Blocked Suspicious IPs</span>
                <span class="text-2xl font-black text-amber-600">{{ count($blockedIps) }}</span>
            </div>
        </div>

        <!-- Blocked IPs & Encrypted Vault -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Temporarily Blocked IPs -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-base font-bold text-slate-900">Active Intrusion IP Blocks</h2>
                @if(empty($blockedIps))
                    <p class="text-xs text-slate-500">No IP addresses are currently throttled or blocked by automated intrusion detection.</p>
                @else
                    <div class="space-y-3">
                        @foreach($blockedIps as $entry)
                            <div class="flex items-center justify-between gap-3 p-3.5 rounded-xl bg-rose-50/70 dark:bg-rose-950/30 border border-rose-200">
                                <div class="text-xs">
                                    <span class="font-mono font-bold text-slate-900">{{ $entry['ip'] ?? 'unknown' }}</span>
                                    <span class="block text-slate-500">Reason: {{ $entry['reason'] ?? 'threshold' }}</span>
                                </div>
                                <form action="{{ route('admin.security.unblock-ip') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ip" value="{{ $entry['ip'] ?? '' }}">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-blue-600 transition">
                                        Unblock
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Encrypted Backups Vault -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-base font-bold text-slate-900">Encrypted Backup Vault (AES-256 + SHA-256)</h2>
                @if(empty($backups))
                    <p class="text-xs text-slate-500">No encrypted snapshots stored yet. Trigger a backup or wait for the 02:30 daily schedule.</p>
                @else
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($backups as $backup)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <span class="font-mono font-semibold text-slate-800 truncate">{{ $backup['name'] }}</span>
                                <span class="text-slate-500 whitespace-nowrap">{{ $backup['size_kb'] }} KB</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Scoped API Tokens Management -->
        @if(Auth::user()?->hasPermission('security.manage'))
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Scoped REST API Tokens</h2>
                    <p class="text-xs text-slate-500">Issue SHA-256 hashed Bearer tokens for `/api/v1/services` and `/api/v1/inquiries` with strict expiration and minimal scopes.</p>
                </div>

                <form action="{{ route('admin.security.tokens.create') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Token Name</label>
                        <input type="text" name="name" required placeholder="CI Integration Read-Only"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Allowed Scopes</label>
                        <div class="flex flex-wrap gap-3 py-2 text-xs">
                            <label class="flex items-center gap-1.5">
                                <input type="checkbox" name="abilities[]" value="services.read" checked class="rounded">
                                <span>services.read</span>
                            </label>
                            <label class="flex items-center gap-1.5">
                                <input type="checkbox" name="abilities[]" value="inquiries.read" class="rounded">
                                <span>inquiries.read</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Expires (Days)</label>
                        <input type="number" name="expires_in_days" value="90" min="1" max="365"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <button type="submit" class="py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold transition">
                        Issue API Token
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                            <tr>
                                <th class="py-2.5 px-4">Token Name</th>
                                <th class="py-2.5 px-4">Scopes</th>
                                <th class="py-2.5 px-4">Last Used</th>
                                <th class="py-2.5 px-4">Status</th>
                                <th class="py-2.5 px-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($apiTokens as $token)
                                <tr>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $token->name }}</td>
                                    <td class="py-3 px-4 font-mono">{{ implode(', ', $token->abilities ?? []) }}</td>
                                    <td class="py-3 px-4">{{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Never' }}</td>
                                    <td class="py-3 px-4">
                                        @if($token->isValid())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Active</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Revoked/Expired</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($token->isValid())
                                            <form action="{{ route('admin.security.tokens.revoke', $token) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 font-bold hover:bg-rose-600 hover:text-white transition">
                                                    Revoke
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-slate-400">No API tokens created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Security Audit Log Feed -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Security Audit Event Log</h2>
                    <p class="text-xs text-slate-500">Secrets, tokens, and raw passwords are automatically redacted.</p>
                </div>
                <div class="flex flex-wrap gap-1.5 text-xs">
                    <a href="{{ route('admin.security.index') }}" class="px-3 py-1.5 rounded-lg font-semibold {{ !$severityFilter ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600' }}">All</a>
                    @foreach(['info', 'warning', 'high', 'critical'] as $sev)
                        <a href="{{ route('admin.security.index', ['severity' => $sev]) }}" class="px-3 py-1.5 rounded-lg font-semibold uppercase {{ $severityFilter === $sev ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $sev }}</a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Time</th>
                            <th class="py-3 px-4">Severity</th>
                            <th class="py-3 px-4">Event</th>
                            <th class="py-3 px-4">Actor / IP</th>
                            <th class="py-3 px-4">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            <tr>
                                <td class="py-3 px-4 whitespace-nowrap text-[11px] text-slate-400">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ match($log->severity) {
                                        'critical' => 'bg-rose-100 text-rose-700',
                                        'high' => 'bg-orange-100 text-orange-700',
                                        'warning' => 'bg-amber-100 text-amber-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    } }}">{{ $log->severity }}</span>
                                </td>
                                <td class="py-3 px-4 font-mono text-[11px] font-semibold text-slate-900">{{ $log->event_type }}</td>
                                <td class="py-3 px-4 text-[11px]">
                                    <div>{{ $log->user?->email ?? 'Guest / System' }}</div>
                                    <div class="text-slate-400 font-mono">{{ $log->ip_address }}</div>
                                </td>
                                <td class="py-3 px-4 text-slate-700">{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">No security audit events recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

