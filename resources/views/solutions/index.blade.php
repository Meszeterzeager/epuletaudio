<x-layouts.app :title="'Megoldások'" meta-description="8 iparágra szabott hangosítási megoldás — templomtól a raktárig. Nézd meg, mit ajánlunk a te területedhez.">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Megoldások', 'url' => route('solutions.index')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="relative overflow-hidden py-24 bg-petrol-950">
        <div class="pointer-events-none absolute -top-24 -left-24 h-80 w-80 rounded-full bg-gold-500/10 blur-3xl animate-pulse" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-16 h-96 w-96 rounded-full bg-petrol-500/20 blur-3xl animate-pulse" style="animation-delay: 1.2s" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="relative justify-center mb-4" />
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400" data-animate="fade-up">8 iparág, 1 rendszerfilozófia</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Megoldások iparág szerint</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Egy templom, egy raktárcsarnok és egy fogászati rendelő gyökeresen más hangosítást kíván — nem csak a hangfalak méretében, hanem a zónázásban, a vezérlésben és a kivitelezés részleteiben is. Nézd meg, mit ajánlunk a te területedhez.
            </p>

            <div class="mt-8 flex flex-wrap justify-center gap-2" data-animate-group>
                @foreach ($solutions as $solution)
                    <a
                        href="#solution-{{ $solution->slug }}"
                        data-animate-item
                        class="rounded-full border border-cream/15 bg-cream/5 px-4 py-2 text-sm text-cream/80 transition-colors hover:border-gold-400/50 hover:text-gold-400"
                    >
                        {{ $solution->industry_name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-6">
            @if ($solutions->isEmpty())
                <p class="text-center text-ink/60">Hamarosan bővül az iparági megoldások listája.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-animate-group>
                    @foreach ($solutions as $solution)
                        <div id="solution-{{ $solution->slug }}" class="scroll-mt-24" data-animate-item>
                            <x-solution-card :solution="$solution" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
