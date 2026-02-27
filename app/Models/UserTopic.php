<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'generation_batch_id',
        'status',
        'payment_status',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /* ===================== RELATIONSHIPS ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function paper()
    {
        return $this->hasOne(Paper::class);
    }

    /* ===================== SCOPES ===================== */

    // public function scopeApproved($query)
    // {
    //     return $query->where('status', 'approved');
    // }

    // public function scopeSubmitted($query)
    // {
    //     return $query->where('status', 'submitted');
    // }

    // public function scopeGenerated($query)
    // {
    //     return $query->where('status', 'generated');
    // }

    // /* ===================== HELPERS ===================== */

    // public function isApproved(): bool
    // {
    //     return $this->status === 'approved';
    // }
}
