<?php

namespace App\Mail;

use App\Models\PurchaseOrder;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PurchaseOrder $purchaseOrder) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Megrendelés — '.$this->purchaseOrder->poNumber(),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.purchase-order',
            with: [
                'purchaseOrder' => $this->purchaseOrder,
                'signatureHtml' => (string) Setting::get('email_signature', ''),
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $purchaseOrder = $this->purchaseOrder;

        return [
            Attachment::fromData(
                fn () => Pdf::loadView('pdf.purchase-order', ['purchaseOrder' => $purchaseOrder])->output(),
                $purchaseOrder->poNumber().'.pdf',
            )->withMime('application/pdf'),
        ];
    }
}
