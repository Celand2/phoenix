<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'max_uses',
        'used_count',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    // Vérifie si le code est utilisable
    public function isUsable(): bool
    {
        if ($this->status !== 'active') return false;
        if ($this->expires_at && now()->greaterThan($this->expires_at)) return false;
        if ($this->used_count >= $this->max_uses) return false;
        return true;
    }
}
