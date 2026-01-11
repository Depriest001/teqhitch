<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'amount',
        'currency',
        'reference',
        'status',
        'meta',
        'paid_at',
    ];

    protected $casts = [
        'meta' => 'array', // cast JSON to array
        'paid_at' => 'datetime',
    ];

    // Relationship: Payment belongs to a student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship: Payment belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
