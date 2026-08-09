@props(['service'])

<a
    href="{{ route('services.show', $service) }}"
    wire:navigate
    data-tilt
    class="group relative flex flex-col justify-end overflow-hidden rounded-2xl bg-petrol-900 aspect-[4/5] p-6 shrink-0 w-72 sm:w-80"
>
    @if ($service->hero_image)
        <img
            src="{{ Storage::url($service->hero_image) }}"
            alt=""
            class="absolute inset-0 h-full w-full object-cover opacity-60 transition-transform duration-500 group-hover:scale-105"
            loading="lazy"
        >
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-petrol-950/90 via-petrol-950/30 to-transparent"></div>

    <div class="relative z-10">
        <h3 class="font-display text-xl font-semibold text-cream">{{ $service->title }}</h3>
        @if ($service->short_description)
            <p class="mt-2 text-sm text-cream/70 line-clamp-2">{{ $service->short_description }}</p>
        @endif
        <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-gold-400 group-hover:gap-2 transition-all">
            Részletek
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
        </span>
    </div>
</a>
