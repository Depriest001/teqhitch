<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'paper_path',
        'software_path',
    ];

    /* ================= RELATIONSHIPS ================= */

    /**
     * Relation to Topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'written_by');
    }

    public function downloads()
    {
        return $this->hasMany(TopicDownload::class);
    }

    /**
     * Get paper URL for download
     */
    public function getPaperUrlAttribute()
    {
        return $this->paper_path ? Storage::url($this->paper_path) : null;
    }

    /**
     * Get software URL for download
     */
    public function getSoftwareUrlAttribute()
    {
        return $this->software_path ? Storage::url($this->software_path) : null;
    }
}
