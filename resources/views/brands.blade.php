<x-layouts.app :title="'Márkáink'" meta-description="Válogatott, professzionális audio- és rögzítéstechnikai márkák — Adam Hall, Cameo, Klotz, König & Meyer, LD Systems, MONACOR, JTS és társaik — amelyekre a rendszereinket építjük.">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Márkáink', 'url' => route('brands')],
        ];

        // 'dark' => a tile with a petrol-950 background, for logos supplied
        // only as white/light artwork (invisible on a white card otherwise).
        $categories = [
            [
                'title' => 'Hangosítás & 100V-os rendszerek',
                'description' => 'A rendszer szíve: erősítők, hangfalak és vezérlőközpontok, amelyek évekig, panasz nélkül szolgálnak.',
                'brands' => [
                    ['name' => 'LD Systems', 'logo' => 'ldsystems.svg'],
                    ['name' => 'IMG StageLine', 'logo' => 'imgstageline.webp'],
                    ['name' => 'MONACOR', 'logo' => 'monacor.svg'],
                    ['name' => 'Castone', 'logo' => 'castone.webp'],
                ],
            ],
            [
                'title' => 'Kábelezés & jelátvitel',
                'description' => 'Nem spórolunk a jelúton — ez dönti el, hogy a hang évek múlva is ugyanolyan tiszta marad-e.',
                'brands' => [
                    ['name' => 'Klotz', 'logo' => 'klotz.webp', 'dark' => true],
                    ['name' => 'Adam Hall Cables', 'logo' => null],
                ],
            ],
            [
                'title' => 'Rögzítés, állványok & rigging',
                'description' => 'Amit a legtöbbször észre sem veszel, pedig biztonságosan és esztétikusan kell tartania mindent.',
                'brands' => [
                    ['name' => 'König & Meyer', 'logo' => 'konigmeyer.webp'],
                    ['name' => 'Gravity', 'logo' => 'gravity.svg'],
                    ['name' => 'Riggatec', 'logo' => 'riggatec.svg'],
                    ['name' => 'Adam Hall', 'logo' => 'adamhall.svg', 'dark' => true],
                ],
            ],
            [
                'title' => 'Mikrofon & vezeték nélküli rendszerek',
                'description' => 'Konferenciáktól a rendezvényekig — megbízható vétel, tiszta beszédátvitel.',
                'brands' => [
                    ['name' => 'JTS', 'logo' => 'jts.svg'],
                ],
            ],
            [
                'title' => 'Fény- & rendezvénytechnika',
                'description' => 'Amikor a hangosítás mellett a látvány is számít.',
                'brands' => [
                    ['name' => 'Cameo', 'logo' => 'cameo.svg'],
                ],
            ],
            [
                'title' => 'Idegenvezető & tárlatvezető rendszerek',
                'description' => 'Csoportos tárlatvezetéshez és szinkrontolmácsoláshoz tervezett, megbízható vevő-adó rendszerek.',
                'brands' => [
                    ['name' => 'Pöschel Aura Guide', 'logo' => null],
                ],
            ],
            [
                'title' => 'Szállítás, rack & védőtokok',
                'description' => 'A rendezett, szervizelhető gépterem és az ütésálló szállítás is a rendszer része.',
                'brands' => [
                    ['name' => 'Robust.hu', 'logo' => 'robusthu.webp'],
                ],
            ],
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
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400" data-animate="fade-up">Válogatott európai és ázsiai gyártók</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Márkáink</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                A rendszereinkbe nem véletlenszerű, olcsó alkatrészek kerülnek. Évek óta bevált, professzionális gyártók komponenseiből építkezünk — a hangfaltól a rögzítéstechnikáig —, hogy a hangzás ne csak az átadás napján, hanem évekkel később is ugyanolyan tiszta maradjon.
            </p>
        </div>
    </section>

    @foreach ($categories as $index => $category)
        <section class="py-16 sm:py-20 {{ $index % 2 === 1 ? 'bg-petrol-50' : '' }}">
            <div class="mx-auto max-w-5xl px-6">
                <div class="max-w-2xl" data-animate="fade-up">
                    <h2 class="font-display text-2xl sm:text-3xl font-semibold text-ink">{{ $category['title'] }}</h2>
                    <p class="mt-3 text-ink/60">{{ $category['description'] }}</p>
                </div>

                <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 {{ count($category['brands']) >= 4 ? 'lg:grid-cols-4' : '' }} gap-4 sm:gap-5" data-animate-group>
                    @foreach ($category['brands'] as $brand)
                        @php $dark = $brand['dark'] ?? false; @endphp
                        <div
                            data-animate-item
                            class="group flex min-h-[7rem] items-center justify-center rounded-2xl border px-4 py-6 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg {{ $dark ? 'border-white/10 bg-petrol-950 hover:border-gold-400/40' : 'border-petrol-100 bg-white hover:border-gold-400/60' }}"
                        >
                            @if ($brand['logo'])
                                <img
                                    src="{{ asset('images/brands/'.$brand['logo']) }}"
                                    alt="{{ $brand['name'] }} logó"
                                    loading="lazy"
                                    decoding="async"
                                    class="max-h-9 sm:max-h-10 w-auto object-contain"
                                >
                            @else
                                <span class="font-display text-lg sm:text-xl font-semibold text-ink transition-colors group-hover:text-petrol-900">
                                    {{ $brand['name'] }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    <x-cta-band
        :title="'Több márkával dolgozunk'"
        :subtitle="'Minden projekthez azt a márkát és komponenseket ajánljuk, amelyek a helyszínhez, a költségkerethez és az elvárt élettartamhoz a legjobban illenek.'"
    />
</x-layouts.app>
