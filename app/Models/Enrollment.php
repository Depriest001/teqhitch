<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'enrolled_at',
        'completed_at',
    ];

    // Relationship: Enrollment belongs to a student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship: Enrollment belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Relationship: Enrollment has many module progresses
    public function moduleProgress()
    {
        return $this->hasMany(ModuleProgress::class, 'enrollment_id');
    }
}
