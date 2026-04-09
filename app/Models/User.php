<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'phone', 'avatar', 'role', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function instructorProfile()
    {
        return $this->hasOne(InstructorProfile::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function instructorCourses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function recentActivities()
    {
        return $this->hasMany(ActivityLog::class)
            ->latest()
            ->limit(6)
            ->select('id', 'user_id', 'action', 'details', 'created_at');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}

