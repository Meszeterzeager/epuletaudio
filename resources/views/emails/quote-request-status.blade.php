<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ asset('images/logo-wordmark.png') }}" class="logo" alt="{{ config('app.name') }}">
</x-mail::header>
</x-slot:header>

Kedves {{ $quoteRequest->name }}!

{!! nl2br(e($customMessage)) !!}

<x-slot:footer>
<x-mail::footer>
{{ config('company.legal_name') }}<br>
{{ config('company.address') }}<br>
{{ config('company.email') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
