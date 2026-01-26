<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Reminder extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'priority',
        'is_dismissed',
        'data'
    ];

    protected $casts = [
        'is_dismissed' => 'boolean',
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_dismissed', false);
    }
}
