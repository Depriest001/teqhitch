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
        return $this->belongsTo(Student::class, 'student_id');
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

    // Relationship: Enrollment has one certificate
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    public function getProgressAttribute()
    {
        $total = $this->course->modules()->count();

        if ($total === 0) {
            return 0;
        }

        $completed = $this->moduleProgress()
            ->where('status', 'completed')
            ->count();

        return (int) round(($completed / $total) * 100);
    }
}
