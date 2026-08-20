<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiwesApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'institution',
        'department',
        'course_of_study',
        'level',
        'matric_number',
        'siwes_start_date',
        'siwes_end_date',
        'letter_ref_number',
        'track_id',
        'preferred_start_date',
        'mode',
        'amount',
        'payment_status',
        'virtual_account_number',
        'virtual_account_bank',
        'virtual_account_name',
        'strowallet_customer_email',
        'strowallet_raw_response',
    ];

    protected $casts = [
        'date_of_birth'         => 'date',
        'siwes_start_date'      => 'date',
        'siwes_end_date'        => 'date',
        'preferred_start_date'  => 'date',
        'amount'                => 'decimal:2',
        'strowallet_raw_response' => 'array',
    ];

    /**
     * Use the public reference (e.g. TQH-SIWES-AB12CD34) for route binding
     * instead of the internal auto-increment id.
     */
    public function getRouteKeyName(): string
    {
        return 'reference';
    }

    public function track()
    {
        return $this->belongsTo(SiwesTrack::class);
    }

    public function trackLabel(): string
    {
        return $this->track?->name ?? '—';
    }
}
