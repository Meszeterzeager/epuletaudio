@if ($solutions->isNotEmpty())
    <section class="py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex items-end justify-between gap-4 mb-8" data-animate="fade-up">
                <h2 class="font-display text-3xl font-semibold text-ink" data-animate="split-up">Megoldások iparág szerint</h2>
                <a href="{{ route('solutions.index') }}" wire:navigate class="text-sm font-semibold text-petrol-900 hover:underline">
                    Összes megoldás &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6" data-animate-group>
                @foreach ($solutions as $solution)
                    <div data-animate-item>
                        <x-solution-card :solution="$solution" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
