<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ asset('images/logo-icon.png') }}" class="logo" alt="{{ config('app.name') }}" width="36" height="25" style="vertical-align:middle;">
<span style="color:#faf7f2; font-family:'Fraunces', Georgia, 'Times New Roman', serif; font-size:20px; font-weight:600; vertical-align:middle; margin-left:8px;">Épület<span style="color:#c9793a;">audio</span></span>
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
