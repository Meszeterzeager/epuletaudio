@props(['solution'])

<a
    href="{{ route('solutions.show', $solution) }}"
    wire:navigate
    data-tilt
    class="group relative flex flex-col justify-end overflow-hidden rounded-2xl bg-ink aspect-square p-6"
>
    @if ($solution->hero_image)
        <img
            src="{{ \App\Services\ImageOptimizer::thumbUrl($solution->hero_image) }}"
            alt=""
            class="absolute inset-0 h-full w-full object-cover opacity-50 transition-all duration-500 group-hover:opacity-70 group-hover:scale-105"
            loading="lazy"
        >
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/20 to-transparent"></div>

    <div class="relative z-10">
        <h3 class="font-display text-xl font-semibold text-cream">{{ $solution->industry_name }}</h3>
        <span class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-cream/70 group-hover:text-gold-400 transition-colors">
            Megoldás megtekintése
        </span>
    </div>
</a>
