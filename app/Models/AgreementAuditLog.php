<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AgreementAuditLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'agreement_id',
        'user_id',
        'action',
        'details',
        'metadata',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(?Agreement $agreement, string $action, ?string $details = null, array $metadata = []): self
    {
        return static::create([
            'agreement_id' => $agreement?->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => $details,
            'metadata' => $metadata,
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 500),
            'created_at' => now(),
        ]);
    }
}

