<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TopicPaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'amount',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'amount' => 'decimal:2'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name, '_');
            }
        });

        static::updating(function ($model) {
            if (!empty($model->name)) {
                $model->slug = Str::slug($model->name, '_');
            }
        });
    }
}
