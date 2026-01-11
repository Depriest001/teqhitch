<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorProfile extends Model
{
    // Explicit table name
    protected $table = 'instructor_profile';
    
    protected $fillable = [
        'user_id', 'bio', 'qualification', 'specialization', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
