<x-layouts.app
    :title="$service->title"
    :meta-description="$service->meta_description ?? $service->short_description"
    :og-image="$service->og_image"
>
    <x-slot:schema>
        <x-schema.service :service="$service" />
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Szolgáltatások', 'url' => route('services.index')],
            ['name' => $service->title, 'url' => route('services.show', $service)],
        ]" />
    </x-slot:schema>

    <section class="relative py-20 bg-petrol-950 overflow-hidden">
        @if ($service->hero_image)
            <img
                src="{{ Storage::url($service->hero_image) }}"
                alt=""
                class="absolute inset-0 h-full w-full object-cover opacity-30"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-petrol-950 via-petrol-950/80 to-petrol-950/40"></div>
        @endif

        <div class="relative mx-auto max-w-4xl px-6 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">Szolgáltatás</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">{{ $service->title }}</h1>
            @if ($service->short_description)
                <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">{{ $service->short_description }}</p>
            @endif
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            @if ($service->description)
                {!! nl2br(e($service->description)) !!}
            @else
                <p class="text-ink/60">A részletes leírás hamarosan érkezik.</p>
            @endif
        </div>
    </section>

    <x-cta-band :title="'Kérek ajánlatot ehhez: ' . $service->title" />
</x-layouts.app>
