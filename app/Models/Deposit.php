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
        'proof',
        'status',
        'approved_at',
        'note',
    ];

    protected $casts = [
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
