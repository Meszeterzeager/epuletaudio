<?php

namespace App\Http\Controllers;

use App\Mail\NewMailboxMessageAlert;
use App\Models\EmailFolder;
use App\Models\EmailMessage;
use App\Models\Setting;
use App\Services\Mailbox as MailboxService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Fogadja a Resend Inbound Email webhookját (Svix-aláírással hitelesített
 * POST kérés) — bejövő levelet ment a Postafiók "Beérkező" mappájába.
 *
 * FONTOS: a pontos payload-mezőneveket (data.from, data.attachments, stb.)
 * a Resend dashboard élő teszt-levelével kell ellenőrizni, mert ez nem
 * tesztelhető élő Resend fiók nélkül — a lenti parse defenzíven, sok
 * fallbackkal próbálja kiolvasni a mezőket.
 */
class ResendInboundWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        if (! $this->hasValidSignature($request)) {
            Log::warning('Resend inbound webhook: érvénytelen aláírás.');

            return response('Invalid signature', 401);
        }

        $payload = $request->json('data', []) ?: $request->all();

        $fromRaw = $payload['from'] ?? $payload['from_email'] ?? '';
        [$fromName, $fromEmail] = $this->parseFromHeader((string) $fromRaw);

        if (blank($fromEmail)) {
            Log::warning('Resend inbound webhook: hiányzó feladó email.', ['payload' => $payload]);

            return response('Missing sender', 422);
        }

        $headers = $payload['headers'] ?? [];
        $messageIdHeader = $headers['Message-Id'] ?? $headers['Message-ID'] ?? $payload['message_id'] ?? null;
        $inReplyTo = $headers['In-Reply-To'] ?? $payload['in_reply_to'] ?? null;

        $threadId = $inReplyTo
            ? (EmailMessage::where('message_id_header', $inReplyTo)->value('thread_id') ?? Str::uuid()->toString())
            : Str::uuid()->toString();

        $message = EmailMessage::create([
            'folder_id' => EmailFolder::inbox()->id,
            'thread_id' => $threadId,
            'direction' => 'inbound',
            'status' => 'unread',
            'message_id_header' => $messageIdHeader,
            'in_reply_to' => $inReplyTo,
            'from_name' => $fromName,
            'from_email' => $fromEmail,
            'to' => (array) ($payload['to'] ?? []),
            'cc' => (array) ($payload['cc'] ?? []),
            'subject' => $payload['subject'] ?? '(nincs tárgy)',
            'body_html' => $payload['html'] ?? null,
            'body_text' => $payload['text'] ?? null,
            'received_at' => now(),
        ]);

        $this->storeAttachments($message, (array) ($payload['attachments'] ?? []));

        $this->notifyAdmin($message);

        MailboxService::sendAutoreply($message);

        return response('OK', 200);
    }

    /**
     * A Resend inbound payload esetleges mellékleteinek elmentése — a pontos
     * mezőneveket (filename/content/content_type) élő teszt-levéllel kell
     * ellenőrizni, ezért ez is defenzíven, hibát nem dobva próbálkozik.
     *
     * @param  array<int, mixed>  $attachments
     */
    private function storeAttachments(EmailMessage $message, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            if (! is_array($attachment)) {
                continue;
            }

            $filename = $attachment['filename'] ?? $attachment['name'] ?? null;
            $content = $attachment['content'] ?? $attachment['data'] ?? null;

            if (blank($filename) || blank($content)) {
                continue;
            }

            try {
                $decoded = base64_decode((string) $content, true);

                if ($decoded === false) {
                    continue;
                }

                $path = "email-attachments/{$message->id}/".Str::random(8).'-'.$filename;
                Storage::disk('local')->put($path, $decoded);

                $message->attachments()->create([
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $attachment['content_type'] ?? $attachment['type'] ?? null,
                    'size' => strlen($decoded),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Resend inbound webhook: melléklet mentése sikertelen.', [
                    'filename' => $filename,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function hasValidSignature(Request $request): bool
    {
        $secret = config('services.resend.webhook_secret');

        if (blank($secret)) {
            // Nincs beállított webhook secret — fejlesztői módban átengedjük,
            // de élesben mindig legyen RESEND_WEBHOOK_SECRET beállítva.
            return ! app()->isProduction();
        }

        $svixId = $request->header('svix-id');
        $svixTimestamp = $request->header('svix-timestamp');
        $svixSignature = $request->header('svix-signature');

        if (blank($svixId) || blank($svixTimestamp) || blank($svixSignature)) {
            return false;
        }

        $secretBytes = base64_decode(Str::after($secret, 'whsec_'));
        $signedContent = "{$svixId}.{$svixTimestamp}.{$request->getContent()}";
        $expectedSignature = base64_encode(hash_hmac('sha256', $signedContent, $secretBytes, true));

        foreach (explode(' ', $svixSignature) as $part) {
            $providedSignature = Str::after($part, ',');

            if (hash_equals($expectedSignature, $providedSignature)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array{0: ?string, 1: string}
     */
    private function parseFromHeader(string $from): array
    {
        if (preg_match('/^(.*?)<(.+?)>$/', $from, $matches)) {
            return [trim($matches[1], " \t\"") ?: null, trim($matches[2])];
        }

        return [null, trim($from)];
    }

    private function notifyAdmin(EmailMessage $message): void
    {
        $notificationEmails = Setting::getEmailList('notification_email');

        if (empty($notificationEmails)) {
            return;
        }

        Mail::to($notificationEmails)->send(new NewMailboxMessageAlert($message));
    }
}
