<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_number',
        'template_id',
        'title',
        'client_name',
        'client_email',
        'client_company',
        'client_phone',
        'client_address',
        'contract_value',
        'currency',
        'status',
        'content',
        'scope_of_work',
        'payment_terms',
        'start_date',
        'end_date',
        'signed_at',
        'finalized_at',
        'cancelled_at',
        'cancellation_reason',
        'pdf_path',
        'pdf_hash',
        'pdf_generated_at',
        'digital_signature_hash',
        'digital_signature_metadata',
        'estamp_number',
        'estamp_certificate_path',
        'estamp_state',
        'estamp_amount',
        'estamp_issued_at',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'contract_value' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'signed_at' => 'datetime',
            'finalized_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'pdf_generated_at' => 'datetime',
            'estamp_issued_at' => 'datetime',
            'estamp_amount' => 'decimal:2',
            'digital_signature_metadata' => 'array',
        ];
    }

    public static function generateNextNumber(): string
    {
        $year = date('Y');
        $prefix = "AGR-{$year}-";

        $latest = static::where('agreement_number', 'like', "{$prefix}%")
            ->orderByDesc('id')
            ->value('agreement_number');

        if ($latest && preg_match('/-(\d+)$/', $latest, $m)) {
            $nextNum = str_pad((int) $m[1] + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $count = static::whereYear('created_at', $year)->count();
            $nextNum = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        }

        return "{$prefix}{$nextNum}";
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(AgreementTemplate::class, 'template_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AgreementAuditLog::class)->orderByDesc('created_at');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isFullySigned(): bool
    {
        return in_array($this->status, ['fully_signed', 'active', 'completed'], true);
    }

    public function hasEstamp(): bool
    {
        return ! empty($this->estamp_number);
    }

    public function hasDigitalSignature(): bool
    {
        return ! empty($this->digital_signature_hash);
    }

    public function getFormattedValue(): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'AUD' => 'A$',
            'CAD' => 'C$',
        ];
        $sym = $symbols[$this->currency] ?? $this->currency . ' ';
        return $sym . number_format((float) $this->contract_value, 2);
    }
}

