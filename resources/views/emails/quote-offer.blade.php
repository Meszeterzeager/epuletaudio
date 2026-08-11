<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ asset('images/logo-wordmark.png') }}" class="logo" alt="{{ config('app.name') }}">
</x-mail::header>
</x-slot:header>

# Ajánlat

Kedves {{ $quoteRequest->name }}!

{!! nl2br(e($customMessage)) !!}

@if ($items->isNotEmpty())
<x-mail::table>
| Tétel | Menny. | Egységár | Összesen |
| :--- | :---: | ---: | ---: |
@foreach ($items as $item)
| {{ $item->title }} | {{ rtrim(rtrim(number_format((float) $item->quantity, 2, ',', ' '), '0'), ',') }} | {{ number_format((float) $item->unit_price, 0, ',', ' ') }} Ft | {{ number_format($item->quantity * (float) $item->unit_price, 0, ',', ' ') }} Ft |
@endforeach
| | | **Összesen** | **{{ number_format($total, 0, ',', ' ') }} Ft** |
</x-mail::table>
@endif

@if ($quoteRequest->status !== 'ordered')
Ha megfelel az ajánlat, az alábbi gombbal egy kattintással megrendelheted — utána kollégáink veszik fel veled a kapcsolatot a részletekkel.

<x-mail::button :url="$orderUrl" color="success">
Megrendelem
</x-mail::button>
@endif

{!! $signatureHtml !!}

<x-slot:footer>
<x-mail::footer>
{{ config('company.legal_name') }}<br>
{{ config('company.address') }}<br>
{{ config('company.email') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
