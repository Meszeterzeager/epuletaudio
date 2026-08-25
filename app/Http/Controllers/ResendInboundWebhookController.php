<?php

namespace App\Http\Controllers;

use App\Mail\NewMailboxMessageAlert;
use App\Models\EmailFolder;
use App\Models\EmailMessage;
use App\Models\Setting;
use App\Services\Mailbox as MailboxService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Fogadja a Resend Inbound Email webhookját (Svix-aláírással hitelesített
 * POST kérés). A webhook payload csak metaadatot (email_id, feladó, tárgy,
 * melléklet-lista) tartalmaz — a levéltörzset és a mellékletek tartalmát a
 * Resend "Receiving" API-jából kell lekérni az email_id alapján:
 * https://resend.com/docs/api-reference/emails/retrieve-received-email
 */
class ResendInboundWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        if (! $this->hasValidSignature($request)) {
            Log::warning('Resend inbound webhook: érvénytelen aláírás.');

            return response('Invalid signature', 401);
        }

        if ($request->input('type') !== 'email.received') {
            return response('Ignored', 200);
        }

        $emailId = $request->input('data.email_id');

        if (blank($emailId)) {
            Log::warning('Resend inbound webhook: hiányzó email_id.', ['payload' => $request->all()]);

            return response('Missing email_id', 422);
        }

        $email = $this->fetchReceivedEmail((string) $emailId);

        if ($email === null) {
            return response('Failed to fetch email', 502);
        }

        [$fromName, $fromEmail] = $this->parseFromHeader((string) ($email['from'] ?? ''));

        if (blank($fromEmail)) {
            Log::warning('Resend inbound webhook: hiányzó feladó email.', ['email_id' => $emailId]);

            return response('Missing sender', 422);
        }

        $headers = $email['headers'] ?? [];
        $messageIdHeader = $email['message_id'] ?? $headers['message-id'] ?? null;
        $inReplyTo = $headers['in-reply-to'] ?? null;

        $threadId = $inReplyTo
            ? (EmailMessage::where('message_id_header', $inReplyTo)->value('thread_id') ?? Str::uuid()->toString())
            : Str::uuid()->toString();

        $message = EmailMessage::create([
            'folder_id' => EmailFolder::inbox()->id,
            'thread_id' => $threadId,
            'direction' => 'inbound',
            'status' => 'unread',
            'resend_message_id' => $emailId,
            'message_id_header' => $messageIdHeader,
            'in_reply_to' => $inReplyTo,
            'from_name' => $fromName,
            'from_email' => $fromEmail,
            'to' => (array) ($email['to'] ?? []),
            'cc' => (array) ($email['cc'] ?? []),
            'subject' => $email['subject'] ?? '(nincs tárgy)',
            'body_html' => $this->resolveHtmlBody($email),
            'body_text' => $email['text'] ?? null,
            'received_at' => now(),
        ]);

        $this->storeAttachments($message, $emailId, (array) ($email['attachments'] ?? []));

        $this->notifyAdmin($message);

        MailboxService::sendAutoreply($message);

        return response('OK', 200);
    }

    /**
     * A teljes beérkező levél lekérése a Resend Receiving API-jából — a
     * webhook payload maga csak metaadatot tartalmaz.
     *
     * @return array<string, mixed>|null
     */
    private function fetchReceivedEmail(string $emailId): ?array
    {
        $response = Http::withToken((string) config('services.resend.key'))
            ->get("https://api.resend.com/emails/receiving/{$emailId}");

        if ($response->failed()) {
            Log::warning('Resend inbound webhook: a levél lekérése sikertelen.', [
                'email_id' => $emailId,
                'status' => $response->status(),
            ]);

            return null;
        }

        return $response->json();
    }

    /**
     * Ha a Resend a HTML törzset data: URI-ként adja vissza (html_format:
     * data_uri, nagyobb leveleknél), itt dekódoljuk vissza sima HTML-lé.
     *
     * @param  array<string, mixed>  $email
     */
    private function resolveHtmlBody(array $email): ?string
    {
        $html = $email['html'] ?? null;

        if (blank($html)) {
            return null;
        }

        if (($email['html_format'] ?? null) === 'data_uri' && str_starts_with((string) $html, 'data:')) {
            $decoded = base64_decode((string) Str::after((string) $html, 'base64,'), true);

            if ($decoded !== false) {
                return $decoded;
            }
        }

        return $html;
    }

    /**
     * A mellékletek letöltése a Resend Attachments API-ján keresztül: minden
     * melléklethez külön hívással kérünk egy ideiglenes download_url-t, majd
     * onnan töltjük le a tartalmat.
     *
     * @param  array<int, mixed>  $attachments
     */
    private function storeAttachments(EmailMessage $message, string $emailId, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            if (! is_array($attachment) || blank($attachment['id'] ?? null)) {
                continue;
            }

            $filename = basename((string) ($attachment['filename'] ?? 'attachment'));

            try {
                $meta = Http::withToken((string) config('services.resend.key'))
                    ->get("https://api.resend.com/emails/receiving/{$emailId}/attachments/{$attachment['id']}");

                $downloadUrl = $meta->json('download_url');

                if ($meta->failed() || blank($downloadUrl)) {
                    Log::warning('Resend inbound webhook: melléklet metaadat lekérése sikertelen.', [
                        'email_id' => $emailId,
                        'attachment_id' => $attachment['id'],
                    ]);

                    continue;
                }

                $download = Http::get($downloadUrl);

                if ($download->failed()) {
                    continue;
                }

                $path = "email-attachments/{$message->id}/".Str::random(8).'-'.$filename;
                Storage::disk('local')->put($path, $download->body());

                $message->attachments()->create([
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $attachment['content_type'] ?? null,
                    'size' => $attachment['size'] ?? strlen($download->body()),
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
            // Nincs beállított webhook secret — csak kifejezetten helyi
            // fejlesztői környezetben (APP_ENV=local) engedjük át aláírás
            // nélkül; minden más környezetben (staging, elgépelt env, stb.)
            // zárva bukik el, hogy hiányzó konfiguráció ne nyisson kaput.
            if (app()->environment('local')) {
                return true;
            }

            Log::warning('Resend inbound webhook: nincs beállítva RESEND_WEBHOOK_SECRET, a kérés elutasítva.');

            return false;
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
