<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'body',
        'from',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeFromAdmin($query)
    {
        return $query->where('from', 'admin');
    }

    public function scopeFromUser($query)
    {
        return $query->where('from', 'user');
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}