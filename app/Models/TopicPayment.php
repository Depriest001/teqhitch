<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'amount',
        'reference',
        'meta',
        'status',
        'user_topic_id'
    ];

    
    protected $casts = [
        'meta' => 'array',
    ];
    /* ================= RELATIONSHIPS ================= */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
