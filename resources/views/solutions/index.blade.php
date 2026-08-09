<x-layouts.app :title="'Megoldások'">
    <x-slot:schema>
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Megoldások', 'url' => route('solutions.index')],
        ]" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Megoldások iparág szerint</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Minden iparágnak más a hangosítási igénye — nézd meg, mit ajánlunk a te területedhez.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-6">
            @if ($solutions->isEmpty())
                <p class="text-center text-ink/60">Hamarosan bővül az iparági megoldások listája.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-animate-group>
                    @foreach ($solutions as $solution)
                        <div data-animate-item>
                            <x-solution-card :solution="$solution" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
