@props(['service'])

@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title,
        'description' => $service->short_description ?? $service->meta_description,
        'url' => route('services.show', $service),
        'provider' => [
            '@type' => 'LocalBusiness',
            'name' => config('app.name'),
            'url' => route('home'),
        ],
        'areaServed' => 'HU',
    ];
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
