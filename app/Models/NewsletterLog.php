<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterLog extends Model
{
    protected $fillable = [
        'newsletter_id',
        'subscriber_id',
        'status',
        'sent_at',
        'error',
    ];

    /**
     * Each log belongs to a newsletter
     */
    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }

    /**
     * Each log belongs to a subscriber
     */
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}