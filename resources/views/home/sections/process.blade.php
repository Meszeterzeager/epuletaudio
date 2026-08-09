@php
    $steps = [
        ['title' => 'Felmérés', 'description' => 'Helyszíni bejárás, igényfelmérés, akusztikai szempontok tisztázása.'],
        ['title' => 'Terv', 'description' => 'Rendszerterv, technológiai javaslat, árajánlat összeállítása.'],
        ['title' => 'Kivitelezés', 'description' => 'Telepítés, kábelezés, beüzemelés a helyszínen.'],
        ['title' => 'Átadás', 'description' => 'Betanítás, dokumentáció, végleges beállítások.'],
        ['title' => 'Support', 'description' => 'Karbantartás, bővítés, technikai támogatás igény esetén.'],
    ];
@endphp

<section class="py-24">
    <div class="mx-auto max-w-7xl px-6">
        <h2 class="font-display text-3xl font-semibold text-ink mb-12 text-center" data-animate="split-up">Hogyan dolgozunk</h2>

        <div class="grid grid-cols-1 sm:grid-cols-5 gap-8" data-animate-group>
            @foreach ($steps as $index => $step)
                <div class="relative" data-animate-item>
                    <div class="flex items-center gap-3 sm:flex-col sm:items-start sm:gap-0">
                        <span class="font-display text-3xl font-semibold text-petrol-300">{{ sprintf('%02d', $index + 1) }}</span>
                        <h3 class="sm:mt-3 font-semibold text-ink">{{ $step['title'] }}</h3>
                    </div>
                    <p class="mt-2 text-sm text-ink/60">{{ $step['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
