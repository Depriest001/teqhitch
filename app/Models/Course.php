<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'subtitle',
        'description',
        'overview',
        'price',
        'duration',
        'thumbnail',
        'icon',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Method (Slug Auto Generation)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        // Generate slug on create
        static::creating(function ($course) {
            $course->slug = static::generateUniqueSlug($course->title);
        });

        // Regenerate slug only if title changes
        static::updating(function ($course) {
            if ($course->isDirty('title')) {
                $course->slug = static::generateUniqueSlug(
                    $course->title,
                    $course->id
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Slug Generator
    |--------------------------------------------------------------------------
    */

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '_' . $count++;
        }

        return $slug;
    }

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

    // Course Features
    public function features()
    {
        return $this->hasMany(CourseFeature::class)->active()->orderBy('position');
    }

    // Course Outcomes
    public function outcomes()
    {
        return $this->hasMany(CourseOutcome::class)->orderBy('position');
    }
}
