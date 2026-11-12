<?php

namespace App\Security;

use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class SecurityLogger
{
    private const BLOCK_PREFIX = 'security:ip_blocked:';
    private const SIGNAL_PREFIX = 'security:ip_signals:';
    private const BLOCKED_INDEX_KEY = 'security:blocked_ip_index';

    /**
     * Sensitive keys that must never appear in security logs or audit payloads.
     */
    private const REDACTED_KEYS = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        'token',
        'api_token',
        'remember_token',
        'bearer',
        'secret',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'recovery_code',
        'totp_code',
        'code',
        'authorization',
        'cookie',
        '_token',
        'private_key',
    ];

    private const SUSPICIOUS_EVENTS = [
        'login_failed',
        'login_locked_attempt',
        'two_factor_failed',
        'unauthorized_access',
        'permission_denied',
        'open_redirect_blocked',
        'upload_rejected',
        'path_traversal_blocked',
        'api_auth_failed',
        'rate_limit_exceeded',
        'csrf_mismatch',
    ];

    public static function log(
        string $eventType,
        string $description,
        string $severity = 'info',
        ?User $user = null,
        ?Request $request = null,
        array $metadata = [],
    ): void {
        $req = $request ?? (app()->bound('request') ? request() : null);
        $ip = $req?->ip();
        $userAgent = $req?->userAgent();
        $method = $req?->method();
        $path = $req ? '/'.ltrim($req->path(), '/') : null;

        $cleanMetadata = self::sanitizeMetadata($metadata);

        $context = [
            'event_type' => $eventType,
            'severity' => $severity,
            'user_id' => $user?->id,
            'ip' => $ip,
            'method' => $method,
            'path' => $path ? mb_substr($path, 0, 255) : null,
            'metadata' => $cleanMetadata,
        ];

        $logLevel = match ($severity) {
            'critical' => 'critical',
            'high' => 'error',
            'warning' => 'warning',
            default => 'info',
        };

        try {
            Log::channel('security')->{$logLevel}($description, $context);
        } catch (Throwable) {
            // Never allow log transport errors to break request execution
        }

        try {
            SecurityLog::create([
                'user_id' => $user?->id,
                'event_type' => mb_substr($eventType, 0, 80),
                'severity' => mb_substr($severity, 0, 20),
                'ip_address' => $ip ? mb_substr($ip, 0, 45) : null,
                'user_agent' => $userAgent ? mb_substr($userAgent, 0, 255) : null,
                'method' => $method ? mb_substr($method, 0, 12) : null,
                'path' => $path ? mb_substr($path, 0, 255) : null,
                'description' => $description,
                'metadata' => $cleanMetadata,
                'created_at' => now(),
            ]);
        } catch (Throwable) {
            // Database may not be migrated yet (e.g. before initial migration)
        }

        if ($ip && in_array($eventType, self::SUSPICIOUS_EVENTS, true)) {
            self::recordSuspiciousSignal($ip, $eventType);
        }
    }

    public static function sanitizeMetadata(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            $normalizedKey = strtolower((string) $key);

            if (in_array($normalizedKey, self::REDACTED_KEYS, true)) {
                $sanitized[$key] = '[REDACTED]';
                continue;
            }

            if (is_array($value)) {
                $sanitized[$key] = self::sanitizeMetadata($value);
            } elseif (is_string($value)) {
                $sanitized[$key] = mb_substr($value, 0, 500);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    public static function recordSuspiciousSignal(string $ip, string $eventType): void
    {
        try {
            $signalKey = self::SIGNAL_PREFIX.sha1($ip);
            $count = (int) Cache::get($signalKey, 0) + 1;
            Cache::put($signalKey, $count, now()->addMinutes(10));

            // Threshold: 20 suspicious security failures from same IP within 10 minutes
            if ($count >= 20 && ! self::isIpBlocked($ip)) {
                $expiresAt = now()->addMinutes(15);
                Cache::put(self::BLOCK_PREFIX.sha1($ip), [
                    'ip' => $ip,
                    'reason' => $eventType,
                    'blocked_at' => now()->toIso8601String(),
                    'expires_at' => $expiresAt->toIso8601String(),
                ], $expiresAt);

                $index = Cache::get(self::BLOCKED_INDEX_KEY, []);
                if (! is_array($index)) {
                    $index = [];
                }
                $index[$ip] = $expiresAt->timestamp;
                Cache::put(self::BLOCKED_INDEX_KEY, $index, now()->addHour());

                Log::channel('security')->critical('Automated temporary IP block triggered due to repeated suspicious activity', [
                    'ip' => $ip,
                    'trigger_event' => $eventType,
                    'signal_count_10m' => $count,
                ]);
            }
        } catch (Throwable) {
            // Cache backend failure should not break request lifecycle
        }
    }

    public static function isIpBlocked(?string $ip): bool
    {
        if (! $ip) {
            return false;
        }

        try {
            return Cache::has(self::BLOCK_PREFIX.sha1($ip));
        } catch (Throwable) {
            return false;
        }
    }

    public static function unblockIp(string $ip): void
    {
        Cache::forget(self::BLOCK_PREFIX.sha1($ip));
        Cache::forget(self::SIGNAL_PREFIX.sha1($ip));

        $index = Cache::get(self::BLOCKED_INDEX_KEY, []);
        if (is_array($index) && isset($index[$ip])) {
            unset($index[$ip]);
            Cache::put(self::BLOCKED_INDEX_KEY, $index, now()->addHour());
        }
    }

    public static function getActiveBlockedIps(): array
    {
        $index = Cache::get(self::BLOCKED_INDEX_KEY, []);
        if (! is_array($index)) {
            return [];
        }

        $active = [];
        $updatedIndex = [];
        $now = now()->timestamp;

        foreach ($index as $ip => $expiresTs) {
            if ($expiresTs > $now && self::isIpBlocked((string) $ip)) {
                $details = Cache::get(self::BLOCK_PREFIX.sha1((string) $ip), []);
                $active[] = is_array($details) ? $details : ['ip' => $ip];
                $updatedIndex[$ip] = $expiresTs;
            }
        }

        Cache::put(self::BLOCKED_INDEX_KEY, $updatedIndex, now()->addHour());

        return $active;
    }
}

