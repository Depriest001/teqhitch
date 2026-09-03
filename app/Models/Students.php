<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Students extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'student_id',
        'full_name',
        'email',
        'phone',
        'password',
        'google_id',
        'gender',
        'address',
        'avatar',
        'study_mode',
        'status',
        'source',
        'siwes_application_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function siwesApplication()
    {
        return $this->belongsTo(SiwesApplication::class);
    }
    
    public function enrollmentApplication()
    {
        return $this->hasOne(EnrollmentApplication::class, 'email', 'email')
            ->where('status', 'approved')
            ->latestOfMany();
    }

    public function getProgramNameAttribute(): ?string
    {
        return match ($this->source) {
            'siwes'      => $this->siwesApplication?->track?->name,
            'enrollment' => $this->enrollmentApplication?->course?->name,
            default      => null, // manual — no data to show yet
        };
    }

    public function getProgramFeeAttribute(): ?float
    {
        // SiwesTrack's fee column is named `price` (see the application
        // form and StoreSiwesApplicationRequest/store()), not `fee` — this
        // was the same silent-null-then-0 bug as $track->fee elsewhere.
        return match ($this->source) {
            'siwes'      => $this->siwesApplication?->track?->price,
            'enrollment' => $this->enrollmentApplication?->course?->price, // adjust column name if different
            default      => null,
        };
    }

    /**
     * Generate the next human-readable student ID, e.g. TQH-STU-000042.
     */
    public static function nextStudentId(): string
    {
        $last = static::orderByDesc('id')->value('id') ?? 0;

        return 'STU_'.str_pad($last + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create (or return the existing) student account for a paid SIWES
     * application, using the applicant's phone number as their initial
     * password — matching what the payment-success page tells them.
     *
     * Call this once payment is confirmed (e.g. from the webhook handler
     * or SiwesApplicationController@success), not from the public form.
     */
    public static function createFromSiwesApplication(SiwesApplication $application, string $password): self
    {
        $student = static::firstOrCreate(
            ['email' => $application->email],
            [
                'student_id'           => static::nextStudentId(),
                'full_name'            => $application->full_name,
                'phone'                => $application->phone,
                'password'             => Hash::make($password),
                'email_verified_at'    => now(),
                'gender'               => $application->gender,
                'address'              => $application->address,
                'study_mode'           => $application->mode === 'physical' ? 'onsite' : 'online',
                'status'               => 'active',
                'source'               => 'siwes',
                'siwes_application_id' => $application->id,
            ]
        );

        // firstOrCreate() only applies the second array when it actually
        // creates a new row — if a Students row for this email already
        // existed (a retry, or a regenerated account), it's returned as-is
        // and email_verified_at above was silently ignored. Backfill it
        // explicitly since the SIWES OTP step already proved this email is
        // real by the time we get here.
        if ($student->email_verified_at === null) {
            $student->forceFill(['email_verified_at' => now()])->save();
        }

        return $student;
    }

    /**
     * Create (or return the existing) student account for an approved
     * course enrollment, using the applicant's phone number as their
     * initial password — same convention as the SIWES flow.
     *
     * Call this once the enrollment is approved (e.g. wherever you currently
     * flip status to 'approved'), not on initial submission.
     */
    public static function createFromEnrollment(EnrollmentApplication $enrollment): self
    {
        return static::firstOrCreate(
            ['email' => $enrollment->email],
            [
                'student_id'              => static::nextStudentId(),
                'full_name'               => trim("{$enrollment->first_name} {$enrollment->last_name}"),
                'phone'                   => $enrollment->phone,
                'password'                => Hash::make($enrollment->phone),
                'study_mode'              => $enrollment->mode === 'online' ? 'online' : 'onsite',
                'status'                  => 'active',
                'source'                  => 'enrollment',
                'enrollment_application_id' => $enrollment->id,
            ]
        );
    }

    /**
     * Find the student matching this Google account, linking the google_id
     * to an existing email match if needed, or creating a brand-new student
     * record if no account exists yet.
     *
     * Call this from your Socialite callback (e.g.
     * SocialAuthController@handleGoogleCallback).
     */
    public static function findOrCreateFromGoogle(\Laravel\Socialite\Contracts\User $googleUser): self
    {
        $student = static::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($student) {
            if (! $student->google_id) {
                $student->update(['google_id' => $googleUser->getId()]);
            }

            return $student;
        }

        return static::create([
            'student_id'         => static::nextStudentId(),
            'full_name'          => $googleUser->getName(),
            'email'              => $googleUser->getEmail(),
            'google_id'          => $googleUser->getId(),
            'avatar'             => $googleUser->getAvatar(),
            'status'             => 'active',
            'source'             => 'manual',
            'email_verified_at'  => now(),
        ]);
    }
}