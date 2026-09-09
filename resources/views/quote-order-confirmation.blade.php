<x-layouts.app :title="'Megrendelés visszaigazolása'">
    <section class="py-24 bg-petrol-950">
        <div class="mx-auto max-w-2xl px-6 text-center">
            <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gold-500/15 text-gold-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </span>
            <h1 class="mt-6 font-display text-3xl sm:text-4xl font-semibold text-cream">
                @if ($alreadyOrdered)
                    Ezt az ajánlatot már megrendelted
                @elseif ($confirmed)
                    Köszönjük a megrendelést!
                @else
                    Megrendeled az ajánlatot?
                @endif
            </h1>
            <p class="mt-4 text-cream/70">
                Kedves {{ $quoteRequest->name }}!
                @if ($alreadyOrdered)
                    A rendszerünk szerint ezt az ajánlatot korábban már megrendelted — kollégáink dolgoznak rajta.
                @elseif ($confirmed)
                    Megrendelésedet rögzítettük, kollégáink megkezdik a beszerzést, és hamarosan felvesszük veled a kapcsolatot a részletekkel és a további lépésekkel kapcsolatban.
                @else
                    Az alábbi gombbal véglegesítheted a megrendelést — utána kollégáink megkezdik a beszerzést, és felvesszük veled a kapcsolatot a részletekkel.
                @endif
            </p>

            @if (! $alreadyOrdered && ! $confirmed)
                <form method="POST" action="{{ $confirmUrl }}" class="mt-8 inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-gold-500 px-8 py-4 text-base font-semibold text-black hover:bg-gold-400 transition-colors">
                        Megrendelés véglegesítése
                    </button>
                </form>
            @else
                <a href="{{ route('home') }}" wire:navigate class="mt-8 inline-flex items-center justify-center rounded-full bg-gold-500 px-8 py-4 text-base font-semibold text-black hover:bg-gold-400 transition-colors">
                    Vissza a főoldalra
                </a>
            @endif
        </div>
    </section>
</x-layouts.app>
