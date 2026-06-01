<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trade_id',
        'category_id',
        'amount',
        'daily_gain',
        'status',
        'activated_at',
        'expires_at',
        'last_claimed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'daily_gain' => 'decimal:2',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_claimed_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    // Vérifie si le claim est disponible
    public function isClaimable(): bool
    {
        if ($this->status !== 'active') return false;
        
        // Un trade expire strictement à la date prévue
        if (now()->greaterThanOrEqualTo($this->expires_at)) return false;

        if (is_null($this->last_claimed_at)) return true;
        
        return now()->greaterThanOrEqualTo($this->last_claimed_at->copy()->addHours(24));
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claims()
    {
        return $this->hasMany(TradeClaim::class);
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }
}