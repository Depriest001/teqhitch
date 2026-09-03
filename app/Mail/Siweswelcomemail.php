<?php

namespace App\Mail;

use App\Models\Students;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent exactly once, from SiwesApplicationController@webhook, the moment a
 * SIWES placement fee payment is confirmed. See webhook() for the
 * Cache::pull()-based guard that prevents this from being sent twice.
 */
class SiwesWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Students $student,
        public string $password,
    ) {}

    public function build()
    {
        return $this->subject('Your SIWES placement account is ready')
            ->markdown('emails.siwes.welcome', [
                'student'  => $this->student,
                'password' => $this->password,
                'loginUrl' => route('login'),
            ]);
    }
}