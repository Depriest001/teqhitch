<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    // Explicit table name
    protected $table = 'students_profile';

    protected $fillable = [
        'user_id', 'address', 'institution'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
