<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'module_id',
        'status',
        'completed_at',
    ];

    // Relationship: ModuleProgress belongs to an enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    // Relationship: ModuleProgress belongs to a course module
    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }
}
