<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Newsletter;

class NewsletterMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Newsletter $newsletter,
        public string $unsubscribeUrl
    ) {}

    // Email subject
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->newsletter->subject,
        );
    }

    // Email content view
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletterMails', // Blade file for newsletter content
            with: [
                'content' => $this->newsletter->content,
                'newsletter' => $this->newsletter, // optional if needed in view
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}