<x-layouts.app :title="'Szolgáltatások'" meta-description="Épülethangosítás, konferenciarendszerek, tourguide-rendszerek, mobil hangosítás és ablakátbeszélő megoldások — nézd meg szolgáltatásainkat.">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Szolgáltatások', 'url' => route('services.index')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Szolgáltatásaink</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Épülethangosítás, konferenciarendszerek, tourguide-rendszerek és mobil hangosítás — a tervezéstől az átadásig.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-6">
            @if ($services->isEmpty())
                <p class="text-center text-ink/60">Hamarosan bővül a szolgáltatáslistánk.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-animate-group>
                    @foreach ($services as $service)
                        <div data-animate-item>
                            <x-service-card :service="$service" class="w-full" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
