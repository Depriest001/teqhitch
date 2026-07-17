<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'icon',
        'image',
        'excerpt',
        'body',
        'author',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Auto-generate slug from title if not provided
    protected static function booted()
    {
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
            if (empty($news->published_at)) {
                $news->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                      ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at');
    }

    // Maps category to your existing tag color classes
    public function getTagClassAttribute(): string
    {
        return match (strtolower($this->category ?? '')) {
            'event' => 'news-tag-green',
            'partnership', 'announcement' => 'news-tag-orange',
            default => 'news-tag-primary',
        };
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('uploads/news/' . $this->image)
            : '';
    }
}