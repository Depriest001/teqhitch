<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementRead extends Model
{
    use HasFactory;

    public $timestamps = false; // you only have read_at, no created_at/updated_at

    protected $fillable = [
        'announcement_id',
        'student_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Relationship: Read belongs to announcement
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }

    // Relationship: Read belongs to student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
