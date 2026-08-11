<x-mail::message>
# Új levél érkezett

**Feladó:** {{ $emailMessage->from_name ? "{$emailMessage->from_name} <{$emailMessage->from_email}>" : $emailMessage->from_email }}
**Tárgy:** {{ $emailMessage->subject }}

{{ \Illuminate\Support\Str::limit(strip_tags($emailMessage->body_text ?? $emailMessage->body_html ?? ''), 300) }}

Ezt az értesítést azért kaptad, mert a Beállításokban megadott értesítési email címre kéred a bejövő levelek jelzését — a teljes levelet és a válaszadási lehetőséget a Postafiók menüpontban találod.

<x-mail::button :url="route('filament.admin.pages.mailbox')">
Megnyitás a Postafiókban
</x-mail::button>
</x-mail::message>
