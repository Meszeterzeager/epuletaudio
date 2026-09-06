<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public string $subjectLine,
        public string $customMessage,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quote-request-status',
            with: [
                'quoteRequest' => $this->quoteRequest,
                'customMessage' => $this->customMessage,
            ],
        );
    }
}
