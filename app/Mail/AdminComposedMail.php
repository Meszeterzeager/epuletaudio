<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AdminComposedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array{path: string, filename: string, mime?: ?string, size?: ?int}>  $attachmentFiles  storage("local")-relatív útvonalak
     */
    public function __construct(
        public string $mailSubject,
        public string $bodyHtml,
        public array $attachmentFiles = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->bodyHtml,
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return collect($this->attachmentFiles)
            ->filter(fn (array $attachment) => Storage::disk('local')->exists($attachment['path']))
            ->map(fn (array $attachment) => Attachment::fromStorageDisk('local', $attachment['path'])
                ->as($attachment['filename'])
                ->withMime($attachment['mime'] ?? 'application/octet-stream'))
            ->values()
            ->all();
    }
}
