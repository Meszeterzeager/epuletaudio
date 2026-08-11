<x-layouts.app :title="'Ajánlatkérés'" meta-description="Kérj részletes, személyre szabott ajánlatot 2 perc alatt.">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Ajánlatkérés', 'url' => route('quote.create')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <div class="bg-petrol-950 py-16">
        <div class="mx-auto max-w-3xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">Ajánlatkérés</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Kérj ajánlatot 2 perc alatt</h1>
            <p class="mt-4 text-cream/70" data-animate="fade-up">Töltsd ki az alábbi 5 lépést, és hamarosan felvesszük veled a kapcsolatot.</p>
        </div>
    </div>

    <livewire:quote-request-wizard />
</x-layouts.app>
