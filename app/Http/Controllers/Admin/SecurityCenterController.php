<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\SecurityLog;
use App\Models\User;
use App\Security\RolePermissions;
use App\Security\SecurityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SecurityCenterController extends Controller
{
    public const ALLOWED_API_SCOPES = [
        'services.read',
        'inquiries.read',
    ];

    public function index(Request $request)
    {
        $severityFilter = in_array($request->query('severity'), ['info', 'warning', 'high', 'critical'], true)
            ? $request->query('severity')
            : null;

        $logsQuery = SecurityLog::with('user:id,name,email,role')
            ->latest('created_at');

        if ($severityFilter) {
            $logsQuery->where('severity', $severityFilter);
        }

        $logs = $logsQuery->paginate(25)->withQueryString();

        $since24h = now()->subDay();
        $stats = [
            'failed_logins_24h' => SecurityLog::where('event_type', 'login_failed')->where('created_at', '>=', $since24h)->count(),
            'high_alerts_24h' => SecurityLog::whereIn('severity', ['high', 'critical'])->where('created_at', '>=', $since24h)->count(),
            'two_factor_enabled' => User::whereNotNull('two_factor_confirmed_at')->count(),
            'total_admins' => User::whereIn('role', ['super_admin', 'admin', 'editor', 'viewer'])->count(),
        ];

        $blockedIps = SecurityLogger::getActiveBlockedIps();
        $apiTokens = ApiToken::with('user:id,name,email')->latest()->get();

        $backupDir = storage_path('app/private/backups');
        $backups = [];
        if (is_dir($backupDir)) {
            foreach (File::files($backupDir) as $file) {
                if (str_ends_with($file->getFilename(), '.enc')) {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'size_kb' => round($file->getSize() / 1024, 1),
                        'modified_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    ];
                }
            }
            usort($backups, fn ($a, $b) => strcmp($b['name'], $a['name']));
        }

        $roleMatrix = RolePermissions::MATRIX;

        return view('admin.security.index', compact(
            'logs',
            'stats',
            'blockedIps',
            'apiTokens',
            'backups',
            'roleMatrix',
            'severityFilter',
        ));
    }

    public function unblockIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
        ]);

        $ip = (string) $request->input('ip');
        SecurityLogger::unblockIp($ip);
        SecurityLogger::log('ip_unblocked', "Admin manually cleared IP block for {$ip}", 'info', Auth::user(), $request, ['ip' => $ip]);

        return back()->with('success', "IP address {$ip} has been unblocked.");
    }

    public function createToken(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'abilities' => 'required|array|min:1',
            'abilities.*' => 'in:'.implode(',', self::ALLOWED_API_SCOPES),
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ]);

        $plainSecret = 'cbc_live_'.Str::random(48);
        $expiresDays = isset($validated['expires_in_days']) ? (int) $validated['expires_in_days'] : 90;

        ApiToken::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'token_hash' => hash('sha256', $plainSecret),
            'abilities' => array_values(array_unique($validated['abilities'])),
            'expires_at' => now()->addDays($expiresDays),
        ]);

        SecurityLogger::log('api_token_created', "Created scoped API token '{$validated['name']}'", 'info', Auth::user(), $request, [
            'abilities' => $validated['abilities'],
            'expires_days' => $expiresDays,
        ]);

        return back()
            ->with('success', 'Scoped API token created. Copy it now — it will not be shown again.')
            ->with('new_api_token', $plainSecret);
    }

    public function revokeToken(Request $request, ApiToken $apiToken)
    {
        $apiToken->forceFill(['revoked_at' => now()])->save();

        SecurityLogger::log('api_token_revoked', "Revoked API token '{$apiToken->name}'", 'warning', Auth::user(), $request, [
            'token_id' => $apiToken->id,
        ]);

        return back()->with('success', 'API token revoked immediately.');
    }

    public function runBackup(Request $request)
    {
        $exitCode = Artisan::call('security:backup');
        if ($exitCode !== 0) {
            SecurityLogger::log('backup_failed', 'Manual encrypted database backup returned non-zero exit status', 'high', Auth::user(), $request);

            return back()->with('error', 'Encrypted backup failed: '.trim(Artisan::output()));
        }

        SecurityLogger::log('manual_backup_executed', 'Admin triggered encrypted database backup', 'info', Auth::user(), $request);

        return back()->with('success', 'Encrypted database backup created safely in private storage.');
    }
}

