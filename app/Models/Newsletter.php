<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = [
        'subject',
        'url',
        'url_text',
        'content',
        'status',
        'send_at',
    ];

    protected $casts = [
        'send_at' => 'datetime',
    ];

    /**
     * A newsletter has many logs (one per subscriber)
     */
    public function logs()
    {
        return $this->hasMany(NewsletterLog::class);
    }

    /**
     * A newsletter belongs to many subscribers through logs
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'newsletter_logs')
                    ->withPivot('status', 'sent_at', 'error')
                    ->withTimestamps();
    }
}