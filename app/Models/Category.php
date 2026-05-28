<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'daily_profit_percent',
        'duration_days',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'daily_profit_percent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    // Relations
    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function userTrades()
    {
        return $this->hasMany(UserTrade::class);
    }
}