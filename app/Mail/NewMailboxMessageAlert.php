<?php

namespace App\Mail;

use App\Models\EmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMailboxMessageAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EmailMessage $emailMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Új levél érkezett: '.$this->emailMessage->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-mailbox-message-alert',
        );
    }
}
