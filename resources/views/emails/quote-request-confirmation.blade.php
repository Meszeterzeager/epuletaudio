<x-mail::message>
# Köszönjük az ajánlatkérésedet, {{ $quoteRequest->name }}!

Megkaptuk a beadott adataidat, és hamarosan felvesszük veled a kapcsolatot.

**Összegzés:**
- Épület/intézmény típusa: {{ \App\Livewire\QuoteRequestWizard::BUILDING_TYPES[$quoteRequest->building_type] ?? $quoteRequest->building_type }}
- Kért rendszerek: {{ collect($quoteRequest->requested_systems)->map(fn ($s) => \App\Livewire\QuoteRequestWizard::REQUESTED_SYSTEMS[$s] ?? $s)->join(', ') }}
@if ($quoteRequest->preferred_timeframe)
- Tervezett kivitelezési időszak: {{ $quoteRequest->preferred_timeframe }}
@endif

Ha bármi kérdésed van, válaszolj erre az emailre.

Üdvözlettel,<br>
Épületaudio csapata
</x-mail::message>
