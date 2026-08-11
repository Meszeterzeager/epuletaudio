<x-layouts.app
    :title="'Épülethangosítás, konferencia-, tourguide- és vészhangosítás'"
    meta-description="Épülethangosítás, konferenciarendszerek, tourguide-rendszerek, mobil hangosítás, EVAC vészhangosítás és ablaküveg-átbeszélő rendszerek tervezéstől a kivitelezésig és átadásig — templomoknak, irodáknak, üzleteknek, intézményeknek és iparnak."
>
    @include('home.sections.hero')
    @include('home.sections.services-strip', ['services' => $services])
    @include('home.sections.counters')
    @include('home.sections.solutions-teaser', ['solutions' => $solutions])
    @include('home.sections.featured-projects', ['featuredProjects' => $featuredProjects])
    @include('home.sections.process')
    @include('home.sections.faq')

    <x-cta-band subtitle="Küldd el a projekt adatait, mi visszahívunk és személyre szabott ajánlatot készítünk." />
</x-layouts.app>
