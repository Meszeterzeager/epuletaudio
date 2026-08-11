<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

class QuoteOfferMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public string $customMessage,
        public bool $includeItems = true,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ajánlat — '.config('app.name'),
        );
    }

    public function content(): Content
    {
        $items = $this->includeItems ? $this->quoteRequest->items : new Collection;

        return new Content(
            markdown: 'emails.quote-offer',
            with: [
                'quoteRequest' => $this->quoteRequest,
                'customMessage' => $this->customMessage,
                'items' => $items,
                'total' => $items->sum(fn ($item) => $item->quantity * (float) $item->unit_price),
                'signatureHtml' => (string) Setting::get('email_signature', ''),
                'orderUrl' => URL::signedRoute('quote.order', ['quoteRequest' => $this->quoteRequest]),
            ],
        );
    }
}
