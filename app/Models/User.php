<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\PaymentMethod;
use App\Support\Money;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'avatar',
        'referral_code',
        'referred_by',
        'status',
        'role',
        'preferred_payment_method_id',
        'preferred_currency',
        'preferred_rate',
        'balance_invested',
        'balance_gains',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferred_rate' => 'decimal:6',
        'balance_invested' => 'decimal:2',
        'balance_gains' => 'decimal:2',
    ];

    // Referral
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    // Trades
    public function userTrades()
    {
        return $this->hasMany(UserTrade::class);
    }

    // Deposits
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    // Withdrawals
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function preferredPaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'preferred_payment_method_id');
    }

    protected static function booted()
    {
        static::saving(function (self $user) {
            if (! $user->isDirty('preferred_payment_method_id')) {
                return;
            }

            if (! $user->preferred_payment_method_id) {
                return;
            }

            $paymentMethod = PaymentMethod::with('exchangeRate')->find($user->preferred_payment_method_id);

            if (! $paymentMethod) {
                return;
            }

            $snapshot = Money::snapshotFor($paymentMethod);
            $user->preferred_currency = $snapshot['currency'];
            $user->preferred_rate = $snapshot['rate'];
        });
    }

    public function syncPreferredCurrencyFromPaymentMethod(): void
    {
        if (! $this->preferred_payment_method_id) {
            return;
        }

        $paymentMethod = PaymentMethod::with('exchangeRate')->find($this->preferred_payment_method_id);

        if (! $paymentMethod) {
            return;
        }

        $snapshot = Money::snapshotFor($paymentMethod);

        if ($this->preferred_currency !== $snapshot['currency'] || (float) $this->preferred_rate !== $snapshot['rate']) {
            $this->update([
                'preferred_currency' => $snapshot['currency'],
                'preferred_rate' => $snapshot['rate'],
            ]);
        }
    }

    // Claims
    public function tradeClaims()
    {
        return $this->hasMany(TradeClaim::class);
    }

    // Messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
