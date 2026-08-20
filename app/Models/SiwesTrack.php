<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiwesTrack extends Model
{
    public const MINIMUM_PRICE = 10000;

    protected $fillable = ['name', 'price'];

    protected $casts = ['price' => 'decimal:2'];

    public function applications()
    {
        return $this->hasMany(SiwesApplication::class, 'id');
    }
}
