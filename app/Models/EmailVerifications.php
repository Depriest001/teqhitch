<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = ['email','otp_code','attempts','verified_at','expires_at'];
    protected $casts = ['verified_at' => 'datetime', 'expires_at' => 'datetime'];

    public static function isVerified(string $email, int $withinHours = 72): bool
    {
        return static::where('email', $email)
            ->whereNotNull('verified_at')
            ->where('verified_at', '>=', now()->subHours($withinHours))
            ->exists();
    }
}
