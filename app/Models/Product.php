<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'thumbnail',
        'link',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Convenience scopes, mirrors what you'd use on the frontend
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeSoftware($query)
    {
        return $query->where('type', 'software');
    }

    public function scopeWebsite($query)
    {
        return $query->where('type', 'website');
    }
}