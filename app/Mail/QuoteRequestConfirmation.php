<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quoteRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Megkaptuk az ajánlatkérésedet — Épületaudio',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quote-request-confirmation',
        );
    }
}
