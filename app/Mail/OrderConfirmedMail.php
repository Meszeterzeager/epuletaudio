<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quoteRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Megrendelésed visszaigazolása — '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-confirmed',
            with: [
                'quoteRequest' => $this->quoteRequest,
            ],
        );
    }
}
