@if ($solutions->isNotEmpty())
    <section class="py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex items-end justify-between gap-4 mb-8" data-animate="fade-up">
                <h2 class="font-display text-3xl font-semibold text-ink" data-animate="split-up">Megoldások iparág szerint</h2>
                <a href="{{ route('solutions.index') }}" wire:navigate class="text-sm font-semibold text-petrol-900 hover:underline">
                    Összes megoldás &rarr;
                </a>
            </div>

            <div class="grid grid-flow-col auto-cols-[70%] sm:auto-cols-fr sm:grid-flow-row sm:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible pb-2 -mx-6 px-6 sm:mx-0 sm:px-0 snap-x snap-mandatory sm:snap-none [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-animate-group>
                @foreach ($solutions as $solution)
                    <div class="snap-start" data-animate-item>
                        <x-solution-card :solution="$solution" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
