<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'title',
        'body',
        'type',
        'is_read',
        'is_emailed',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_emailed' => 'boolean',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeNotEmailed($query)
    {
        return $query->where('is_emailed', false);
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
