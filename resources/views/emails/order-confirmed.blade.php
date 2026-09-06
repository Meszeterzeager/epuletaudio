<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ asset('images/logo-wordmark.png') }}" class="logo" alt="{{ config('app.name') }}">
</x-mail::header>
</x-slot:header>

# Megrendelés visszaigazolva

Kedves {{ $quoteRequest->name }}!

Köszönjük a megrendelésed! Kollégáink hamarosan felveszik veled a kapcsolatot az ütemezés egyeztetéséhez, és külön emailben küldjük a díjbekérőt (proforma számlát) a fizetéshez szükséges adatokkal.

Ha bármi kérdésed van, egyszerűen válaszolj erre az emailre.

Üdvözlettel,<br>
Épületaudio csapata

<x-slot:footer>
<x-mail::footer>
{{ config('company.legal_name') }}<br>
{{ config('company.address') }}<br>
{{ config('company.email') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
