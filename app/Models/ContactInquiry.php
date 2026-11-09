<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'service_interested',
        'status',
        'admin_notes',
        'ip_address',
    ];

    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }
}

