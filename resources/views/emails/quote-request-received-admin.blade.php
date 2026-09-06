<x-mail::message>
# Új ajánlatkérés érkezett

Új árajánlatkérés érkezett **{{ $quoteRequest->name }}** részéről.

@if ($quoteRequest->needed_by_date)
**Legkésőbb szükséges dátum:** {{ $quoteRequest->needed_by_date->format('Y.m.d.') }} — ez alapján érdemes priorizálni a reakciót.
@endif

A részletek megtekintéséhez és a gyors reagáláshoz jelentkezz be az adminba.

<x-mail::button :url="route('filament.admin.resources.quote-requests.view', $quoteRequest)">
Megnyitás az adminban
</x-mail::button>
</x-mail::message>
