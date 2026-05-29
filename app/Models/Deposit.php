<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_trade_id',
        'payment_method_id',
        'amount_usd',
        'amount_local',
        'currency_local',
        'exchange_rate',
        'proof',
        'status',
        'approved_at',
        'note',
    ];

    protected $casts = [
        'amount_usd' => 'decimal:2',
        'amount_local' => 'decimal:2',
        'exchange_rate' => 'decimal:6',
        'approved_at' => 'datetime',
    ];

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userTrade()
    {
        return $this->belongsTo(UserTrade::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
