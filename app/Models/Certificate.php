<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'certificate_code',
        'thumbnail',
        'file_path',
        'issued_at',
        'delete_status',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    // Relationship: Certificate belongs to a student
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
    
    public function getRouteKeyName()
    {
        return 'certificate_code';
    }
}
