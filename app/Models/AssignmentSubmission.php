<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'submitted_at',
        'score',
        'feedback',
        'graded_at',
    ];
    
    // ✨ Cast dates to Carbon
    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship: Submission belongs to an assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    // Relationship: Submission belongs to a student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getStatusAttribute()
    {
        // Graded takes priority
        if ($this->score !== null || $this->graded_at !== null) {
            return 'graded';
        }

        // Submitted but not graded
        if ($this->submitted_at) {
            return $this->submitted_at > $this->assignment->deadline ? 'late' : 'submitted';
        }

        // Not submitted yet
        return 'pending';
    }

}
