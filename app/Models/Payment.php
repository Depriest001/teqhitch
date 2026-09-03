<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payable_type',
        'payable_id',
        'amount',
        'currency',
        'gateway',
        'reference',
        'status',
        'meta',
        'paid_at',
    ];

    protected $casts = [
        'meta'    => 'array', // cast JSON to array
        'paid_at' => 'datetime',
    ];

    // Relationship: Payment belongs to a student
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    // Relationship: Payment belongs to whatever it's paying for
    // (Course, SiwesTrack, etc.)
    public function payable()
    {
        return $this->morphTo();
    }

    // Convenience: filter payments down to a specific payable type
    public function scopeForCourse($query)
    {
        return $query->where('payable_type', Course::class);
    }

    public function scopeForSiwesTrack($query)
    {
        return $query->where('payable_type', SiwesTrack::class);
    }
}