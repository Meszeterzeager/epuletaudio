@if ($services->isNotEmpty())
    <section class="py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex items-end justify-between gap-4 mb-8" data-animate="fade-up">
                <h2 class="font-display text-3xl font-semibold text-ink" data-animate="split-up">Szolgáltatásaink</h2>
                <a href="{{ route('services.index') }}" wire:navigate class="text-sm font-semibold text-petrol-900 hover:underline">
                    Összes szolgáltatás &rarr;
                </a>
            </div>
        </div>

        <div class="pl-6 sm:pl-[max(1.5rem,calc((100vw-80rem)/2+1.5rem))] flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory" data-animate-group>
            @foreach ($services as $service)
                <div class="snap-start" data-animate-item>
                    <x-service-card :service="$service" />
                </div>
            @endforeach
            <div class="w-1 shrink-0" aria-hidden="true"></div>
        </div>
    </section>
@endif
