<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'email',
        'is_active',
        'token',
        'subscribed_at',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime',
    ];

    /**
     * Scope: Get only active subscribers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Activate subscriber
     */
    public function activate()
    {
        $this->update([
            'is_active' => true,
            'token' => null,
            'subscribed_at' => now(),
        ]);
    }

    /**
     * Deactivate subscriber (unsubscribe)
     */
    public function deactivate()
    {
        $this->update([
            'is_active' => false
        ]);
    }
    
    /**
     * A subscriber has many logs
     */
    public function logs()
    {
        return $this->hasMany(NewsletterLog::class);
    }

    /**
     * A subscriber receives many newsletters
     */
    public function newsletters()
    {
        return $this->belongsToMany(Newsletter::class, 'newsletter_logs')
                    ->withPivot('status', 'sent_at', 'error')
                    ->withTimestamps();
    }
}