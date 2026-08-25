<?php

namespace App\Services;

use App\Mail\AdminComposedMail;
use App\Models\EmailFolder;
use App\Models\EmailMessage;
use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Mailbox
{
    /**
     * Levél összeállítása és elküldése Resenden keresztül, majd a küldött
     * levél elmentése az "Elküldött" mappába.
     *
     * @param  array<int, array{name?: ?string, email: string}>  $to
     * @param  array<int, array{path: string, filename: string, mime?: ?string, size?: ?int}>  $attachments  storage("local")-relatív útvonalak
     */
    public static function send(
        array $to,
        string $subject,
        string $bodyHtml,
        ?string $threadId = null,
        ?string $inReplyTo = null,
        array $attachments = [],
        bool $isAutoreply = false,
    ): EmailMessage {
        $recipients = collect($to)
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($recipients)) {
            throw new \InvalidArgumentException('Legalább egy címzett szükséges.');
        }

        Mail::to($recipients)->send(new AdminComposedMail($subject, $bodyHtml, $attachments));

        $message = EmailMessage::create([
            'folder_id' => EmailFolder::sent()->id,
            'thread_id' => $threadId ?? Str::uuid()->toString(),
            'direction' => 'outbound',
            'status' => 'read',
            'in_reply_to' => $inReplyTo,
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to' => $recipients,
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'is_autoreply' => $isAutoreply,
            'sent_at' => now(),
        ]);

        foreach ($attachments as $attachment) {
            $message->attachments()->create([
                'filename' => $attachment['filename'],
                'path' => $attachment['path'],
                'mime_type' => $attachment['mime'] ?? null,
                'size' => $attachment['size'] ?? null,
            ]);
        }

        return $message;
    }

    public static function buildReplySubject(string $originalSubject): string
    {
        return Str::startsWith(mb_strtolower(trim($originalSubject)), 're:')
            ? $originalSubject
            : "Re: {$originalSubject}";
    }

    public static function buildReplyBody(EmailMessage $original): string
    {
        $quoted = $original->body_html
            ? static::stripDangerousHtml($original->body_html)
            : nl2br(e($original->body_text ?? ''));
        $fromLabel = $original->from_name ? "{$original->from_name} <{$original->from_email}>" : $original->from_email;

        return '<p></p><blockquote style="border-left:2px solid #ccc;padding-left:12px;color:#666;">'
            .'<p><em>'.e($fromLabel).' írta:</em></p>'
            .$quoted
            .'</blockquote>';
    }

    public static function buildForwardSubject(string $originalSubject): string
    {
        return Str::startsWith(mb_strtolower(trim($originalSubject)), 'fwd:')
            ? $originalSubject
            : "Fwd: {$originalSubject}";
    }

    public static function buildForwardBody(EmailMessage $original): string
    {
        $quoted = $original->body_html
            ? static::stripDangerousHtml($original->body_html)
            : nl2br(e($original->body_text ?? ''));
        $fromLabel = $original->from_name ? "{$original->from_name} <{$original->from_email}>" : $original->from_email;
        $date = $original->received_at?->format('Y-m-d H:i') ?? $original->sent_at?->format('Y-m-d H:i') ?? $original->created_at?->format('Y-m-d H:i');

        return '<p></p><p>---------- Továbbított üzenet ----------<br>'
            .'Től: '.e($fromLabel).'<br>'
            .'Dátum: '.e((string) $date).'<br>'
            .'Tárgy: '.e((string) $original->subject).'</p>'
            .$quoted;
    }

    /**
     * Címzett-javaslatok a beírt szöveg alapján — korábbi levelezőpartnerek és
     * az ajánlatkérésekben szereplő ügyfelek közül, e-mail cím szerint
     * egyedítve.
     *
     * @param  array<int, string>  $excludeEmails
     * @return array<int, array{name: string, email: string}>
     */
    public static function contactSuggestions(string $query, array $excludeEmails = []): array
    {
        $query = trim($query);

        if ($query === '') {
            return [];
        }

        $term = '%'.$query.'%';
        $exclude = array_map('mb_strtolower', $excludeEmails);

        $correspondents = EmailMessage::query()
            ->whereNotNull('from_email')
            ->where(function ($q) use ($term) {
                $q->where('from_email', 'like', $term)
                    ->orWhere('from_name', 'like', $term);
            })
            ->orderByDesc('id')
            ->limit(20)
            ->get(['from_name', 'from_email'])
            ->map(fn (EmailMessage $m) => ['name' => $m->from_name ?: $m->from_email, 'email' => $m->from_email]);

        $customers = QuoteRequest::query()
            ->whereNotNull('email')
            ->where(function ($q) use ($term) {
                $q->where('email', 'like', $term)
                    ->orWhere('name', 'like', $term);
            })
            ->orderByDesc('id')
            ->limit(20)
            ->get(['name', 'email'])
            ->map(fn (QuoteRequest $q) => ['name' => $q->name ?: $q->email, 'email' => $q->email]);

        return $correspondents->merge($customers)
            ->filter(fn (array $c) => filled($c['email']))
            ->unique(fn (array $c) => mb_strtolower($c['email']))
            ->reject(fn (array $c) => in_array(mb_strtolower($c['email']), $exclude, true))
            ->values()
            ->take(8)
            ->all();
    }

    /**
     * Eldönti, hogy egy beérkező levélre kell-e automatikus választ küldeni:
     * a funkció be van kapcsolva, a mai dátum a beállított időszakon belül
     * van, és ebben a levélszálban még nem ment ki automata válasz.
     */
    public static function shouldSendAutoreply(EmailMessage $inbound): bool
    {
        if (! Setting::getBool('autoresponder_enabled', false)) {
            return false;
        }

        $today = now()->toDateString();
        $start = (string) Setting::get('autoresponder_start', '');
        $end = (string) Setting::get('autoresponder_end', '');

        if (filled($start) && $today < $start) {
            return false;
        }

        if (filled($end) && $today > $end) {
            return false;
        }

        return ! EmailMessage::where('thread_id', $inbound->thread_id)
            ->where('is_autoreply', true)
            ->exists();
    }

    public static function sendAutoreply(EmailMessage $inbound): void
    {
        if (! static::shouldSendAutoreply($inbound)) {
            return;
        }

        $text = trim((string) Setting::get('autoresponder_message', ''));

        if (blank($text) || blank($inbound->from_email)) {
            return;
        }

        static::send(
            to: [['name' => $inbound->from_name, 'email' => $inbound->from_email]],
            subject: static::buildReplySubject((string) $inbound->subject),
            bodyHtml: nl2br(e($text)),
            threadId: $inbound->thread_id,
            inReplyTo: $inbound->message_id_header,
            isAutoreply: true,
        );
    }

    /**
     * Egy idézett (nem a mi rendszerünkben keletkezett, hanem egy külső
     * beérkező levélből származó) HTML töredék tisztítása egy valódi
     * allowlist-alapú HTML-sanitizálóval (HTMLPurifier), mielőtt a
     * válaszba/továbbításba beépülne és kimenne egy külső címzettnek —
     * csak az explicit engedélyezett tageken/attribútumokon jut át bármi,
     * úgyhogy nincs regex-alapú megkerülési lehetőség (pl. hiányzó
     * szóköz az on-eseménykezelő előtt, szokatlan tagek stb.).
     */
    private static function stripDangerousHtml(string $html): string
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', storage_path('app/htmlpurifier-cache'));
        $config->set('HTML.Allowed', 'p,br,div,span,strong,b,em,i,u,ul,ol,li,blockquote,a[href],table,thead,tbody,tr,td,th,h1,h2,h3,h4,h5,h6,img[src|alt|width|height]');
        $config->set('HTML.TargetBlank', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);

        if (! is_dir(storage_path('app/htmlpurifier-cache'))) {
            mkdir(storage_path('app/htmlpurifier-cache'), recursive: true);
        }

        return (new \HTMLPurifier($config))->purify($html);
    }

    /**
     * A beállításokban tárolt (HTML) aláírás egyszerű szöveges változata,
     * hogy előtölthető legyen az admin sima szövegdobozába — onnan az admin
     * szabadon szerkesztheti vagy törölheti, mielőtt elküldi a levelet.
     */
    public static function signatureAsPlainText(): string
    {
        $signature = (string) Setting::get('email_signature', '');

        if (blank($signature)) {
            return '';
        }

        $text = preg_replace('/>\s+</', '><', $signature) ?? $signature;
        $text = preg_replace('/<br\s*\/?>/i', "\n", $text) ?? $text;
        $text = preg_replace('/<\/p>/i', "\n\n", $text) ?? $text;
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        $text = implode("\n", array_map('trim', explode("\n", $text)));
        $text = preg_replace('/\n{3,}/', "\n\n", $text) ?? $text;

        return trim($text);
    }
}
