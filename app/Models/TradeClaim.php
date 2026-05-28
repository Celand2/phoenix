<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_trade_id',
        'amount',
        'claimed_at',
        'next_claim_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'claimed_at' => 'datetime',
        'next_claim_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userTrade()
    {
        return $this->belongsTo(UserTrade::class);
    }
}