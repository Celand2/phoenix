<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'amount_requested',
        'fee',
        'amount_received',
        'status',
        'account_number',
        'account_name',
        'approved_at',
        'note',
    ];

    protected $casts = [
        'amount_requested' => 'decimal:2',
        'fee' => 'decimal:2',
        'amount_received' => 'decimal:2',
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

    // Calcul automatique des frais et montant reçu
    public static function calculateFee(float $amount): array
    {
        $fee = $amount * 0.10;
        $received = $amount - $fee;
        return ['fee' => $fee, 'amount_received' => $received];
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
