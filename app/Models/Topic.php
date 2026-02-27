<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'academic_level',
        'paper_type',
        'department',
        'usage_count',
        'average_rating',
        'status'
    ];

    /* ================= RELATIONSHIPS ================= */

    public function userTopics()
    {
        return $this->hasMany(UserTopic::class);
    }

    public function ratings()
    {
        return $this->hasMany(TopicRating::class);
    }
    
    public function paper()
    {
        return $this->hasOne(Paper::class);
    }
}
