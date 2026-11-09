<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DigitalSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'category',
        'short_description',
        'full_description',
        'features',
        'benefits',
        'technologies',
        'order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'benefits' => 'array',
        'technologies' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }
}

