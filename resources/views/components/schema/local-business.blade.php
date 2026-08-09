@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => config('app.name'),
        'legalName' => config('company.legal_name'),
        'url' => route('home'),
        'email' => config('company.email'),
        'telephone' => config('company.phone') ?: null,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => config('company.street'),
            'addressLocality' => config('company.city'),
            'postalCode' => config('company.postal_code'),
            'addressCountry' => config('company.country'),
        ],
        'areaServed' => 'HU',
    ]);
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
