<x-mail::message>
# Díjbekérő

Kedves {{ $quoteRequest->name }}!

{{ $customMessage }}

- **Díjbekérő azonosító:** {{ $paymentRequestNumber }}
- **Fizetendő összeg:** {{ number_format($totalAmount, 0, ',', ' ') }} Ft
- **Fizetési határidő:** {{ $dueDate }}

A részletes díjbekérőt csatoltuk PDF formátumban, a fizetéshez szükséges banki adatokkal együtt.

Ha bármi kérdésed van, válaszolj erre az emailre.

Üdvözlettel,<br>
Épületaudio csapata
</x-mail::message>
