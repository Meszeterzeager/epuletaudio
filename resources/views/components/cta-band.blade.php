@props(['title' => 'Kérj ajánlatot 2 perc alatt', 'subtitle' => null])

<section class="mx-auto max-w-7xl px-6 my-24">
    <div class="rounded-3xl bg-petrol-900 px-8 py-16 sm:px-16 text-center" data-animate="fade-up">
        <h2 class="font-display text-3xl sm:text-4xl font-semibold text-cream">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-4 text-cream/70 max-w-xl mx-auto">{{ $subtitle }}</p>
        @endif
        <a
            href="{{ route('quote.create') }}"
            data-magnetic="0.3"
            wire:navigate
            class="mt-8 inline-flex items-center justify-center rounded-full bg-gold-500 px-8 py-4 text-base font-semibold text-petrol-950 hover:bg-gold-400 transition-colors"
        >
            Ajánlatot kérek
        </a>
    </div>
</section>
