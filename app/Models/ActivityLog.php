<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'details',
        'ip_address',
        'device',
    ];

    protected $casts = [
        'details' => 'array', // if storing JSON in details
    ];

    // Relationship: ActivityLog belongs to a user (nullable)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
