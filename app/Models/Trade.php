<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'amount',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function userTrades()
    {
        return $this->hasMany(UserTrade::class);
    }

    // Calcul gain journalier
    public function dailyGain()
    {
        return $this->amount * $this->category->daily_profit_percent / 100;
    }
}