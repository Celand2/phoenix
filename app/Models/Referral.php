<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'level',
        'commission_percent',
        'commission_amount',
        'user_trade_id',
        'status',
    ];

    protected $casts = [
        'commission_percent' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeLevel($query, int $level)
    {
        return $query->where('level', $level);
    }

    // Relations
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function userTrade()
    {
        return $this->belongsTo(UserTrade::class);
    }
}
