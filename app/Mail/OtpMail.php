<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public int $expiresInMinutes;
    public ?string $heading;
    public ?string $intro;
    protected string $emailSubject;

    /**
     * @param string      $code             The one-time code to display.
     * @param int         $expiresInMinutes How long the code is valid for.
     * @param string|null $subject          Email subject line. Falls back to a sensible default.
     * @param string|null $heading          Bold heading shown above the code (e.g. "Verify your email").
     * @param string|null $intro            Short sentence explaining why the code was sent.
     */
    public function __construct(
        string $code,
        int $expiresInMinutes = 10,
        ?string $subject = null,
        ?string $heading = null,
        ?string $intro = null
    ) {
        $this->code = $code;
        $this->expiresInMinutes = $expiresInMinutes;
        $this->emailSubject = $subject ?? 'Your verification code';
        $this->heading = $heading;
        $this->intro = $intro;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'code' => $this->code,
                'expiresInMinutes' => $this->expiresInMinutes,
                'subject' => $this->emailSubject,
                'heading' => $this->heading,
                'intro' => $this->intro,
            ],
        );
    }
}