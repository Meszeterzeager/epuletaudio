<x-layouts.app
    :title="$solution->meta_title ?? $solution->industry_name"
    :meta-description="$solution->meta_description"
    :og-image="$solution->og_image"
>
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Megoldások', 'url' => route('solutions.index')],
            ['name' => $solution->industry_name, 'url' => route('solutions.show', $solution)],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="relative py-20 bg-petrol-950 overflow-hidden">
        @if ($solution->hero_image)
            <img
                src="{{ Storage::url($solution->hero_image) }}"
                alt=""
                class="absolute inset-0 h-full w-full object-cover opacity-30"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-petrol-950 via-petrol-950/80 to-petrol-950/40"></div>
        @endif

        <div class="relative mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">Megoldás</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">{{ $solution->industry_name }}</h1>
            @if ($solution->description)
                <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">{{ Str::limit($solution->description, 200) }}</p>
            @endif
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            @if ($solution->description)
                {!! nl2br(e($solution->description)) !!}
            @else
                <p class="text-ink/60">A részletes leírás hamarosan érkezik.</p>
            @endif
        </div>
    </section>

    @if (!empty($solution->challenges) || !empty($solution->recommended_package))
        <section class="py-20 bg-petrol-50">
            <div class="mx-auto max-w-5xl px-6 grid grid-cols-1 sm:grid-cols-2 gap-12" data-animate-group>
                @if (!empty($solution->challenges))
                    <div data-animate-item>
                        <h2 class="font-display text-2xl font-semibold text-ink mb-6">Tipikus kihívások</h2>
                        <ul class="space-y-4">
                            @foreach ($solution->challenges as $challenge)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 mt-0.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" /></svg>
                                    <span class="text-ink/80">{{ $challenge }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($solution->recommended_package))
                    <div data-animate-item>
                        <h2 class="font-display text-2xl font-semibold text-ink mb-6">Ajánlott technológia csomag</h2>
                        <ul class="space-y-4">
                            @foreach ($solution->recommended_package as $item)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 mt-0.5 text-petrol-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span class="text-ink/80">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if ($solution->projects->isNotEmpty())
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-6">
                <h2 class="font-display text-3xl font-semibold text-ink mb-8" data-animate="split-up">Referenciák ebben az iparágban</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-animate-group>
                    @foreach ($solution->projects as $project)
                        <div data-animate-item>
                            <x-project-card :project="$project" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-band :title="'Kérek ajánlatot ehhez: ' . $solution->industry_name" />
</x-layouts.app>
