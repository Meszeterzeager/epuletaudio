<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public QuoteRequest $quoteRequest,
        public string $customMessage,
        public string $dueDate,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Díjbekérő — '.$this->paymentRequestNumber(),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-request',
            with: [
                'quoteRequest' => $this->quoteRequest,
                'customMessage' => $this->customMessage,
                'paymentRequestNumber' => $this->paymentRequestNumber(),
                'dueDate' => $this->dueDate,
                'totalAmount' => $this->totalAmount(),
            ],
        );
    }

    public function attachments(): array
    {
        $quoteRequest = $this->quoteRequest;
        $paymentRequestNumber = $this->paymentRequestNumber();
        $dueDate = $this->dueDate;
        $totalAmount = $this->totalAmount();

        return [
            Attachment::fromData(
                fn () => Pdf::loadView('pdf.payment-request', [
                    'quoteRequest' => $quoteRequest,
                    'paymentRequestNumber' => $paymentRequestNumber,
                    'dueDate' => $dueDate,
                    'totalAmount' => $totalAmount,
                ])->output(),
                $paymentRequestNumber.'.pdf',
            )->withMime('application/pdf'),
        ];
    }

    public function paymentRequestNumber(): string
    {
        return sprintf('DB-%s-%03d', now()->format('Ymd'), $this->quoteRequest->id);
    }

    public function totalAmount(): float
    {
        return (float) $this->quoteRequest->items
            ->sum(fn ($item) => $item->quantity * (float) $item->unit_price);
    }
}
