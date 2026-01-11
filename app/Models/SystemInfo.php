<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemInfo extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'system_info';

    protected $fillable = [
        'site_name',
        'site_logo',
        'favicon',
        'support_email',
        'support_phone',
        'timezone',
        'address',
        'about',
        'social_links',
        'maintenance_mode',
        'registration_open',
    ];

    protected $casts = [
        'social_links' => 'array',
        'maintenance_mode' => 'boolean',
        'registration_open' => 'boolean',
    ];
}
