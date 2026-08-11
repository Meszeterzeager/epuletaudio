<x-mail::message>
# Megrendelés — {{ $purchaseOrder->poNumber() }}

Tisztelt {{ $purchaseOrder->supplier->name }}!

Mellékelten küldjük a(z) **{{ $purchaseOrder->poNumber() }}** számú megrendelésünket ({{ number_format($purchaseOrder->totalAmount(), 0, ',', ' ') }} Ft értékben) — a részletek a csatolt PDF-ben találhatók. Kérjük, szíveskedjenek visszaigazolni a megrendelést.

Köszönjük!

{!! $signatureHtml !!}
</x-mail::message>
