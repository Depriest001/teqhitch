<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'posted_by_id',
        'posted_by_type',
        'title',
        'message',
        'type',
        'audience',
        'course_id',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationship: Announcement belongs to the user who posted it
    public function poster()
    {
        return $this->morphTo();
    }

    // Relationship: Students who have read this announcement
    public function reads()
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id');
    }

    /**
     * Relation to course (only for type = course)
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
