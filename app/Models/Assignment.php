<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'instructor_id',
        'title',
        'instructions',
        'deadline',
        'max_score',
    ];

    // Relationship: Assignment belongs to a course
    public function Module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    // Relationship: Assignment belongs to an instructor
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Relationship: Assignment has many submissions
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
    
}
