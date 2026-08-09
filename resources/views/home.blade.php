<x-layouts.app>
    <x-slot:schema>
        <x-schema.local-business />
    </x-slot:schema>

    @include('home.sections.hero')
    @include('home.sections.services-strip', ['services' => $services])
    @include('home.sections.counters')
    @include('home.sections.solutions-teaser', ['solutions' => $solutions])
    @include('home.sections.featured-projects', ['featuredProjects' => $featuredProjects])
    @include('home.sections.process')

    <x-cta-band subtitle="Küldd el a projekt adatait, mi visszahívunk és személyre szabott ajánlatot készítünk." />
</x-layouts.app>
