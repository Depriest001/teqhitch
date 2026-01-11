<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'description',
        'price',
        'duration',
        'thumbnail',
        'status',
    ];

    /**
     * Get the instructor (user) who owns the course.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get all modules of the course.
     */
    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id')->orderBy('position');
    }
    
    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class); // make sure you import App\Models\Assignment
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'enrollments',      // pivot table
            'course_id',        // foreign key on pivot for course
            'student_id'        // foreign key on pivot for user
        );
    }
}
