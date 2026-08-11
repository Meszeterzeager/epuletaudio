<x-layouts.app :title="'Rólunk'" meta-description="Nincsenek dobozos megoldások — csak az Ön épületére szabott hangzás. Ismerd meg, hogyan tervezzük és kivitelezzük a rendszereket.">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Rólunk', 'url' => route('about')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400" data-animate="fade-up">Rólunk</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">
                Nincsenek dobozos megoldások. Csak az Ön épületére szabott hangzás.
            </h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Egy épülethangosítási rendszer nem olyan, mint egy otthoni Hi-Fi, amit levisz a polcról az ember, bedugja a konnektorba, és működik. Nincs két egyforma akusztikájú csarnok, nincsenek azonos alaprajzú irodaházak, és egy műemlék templom sem ugyanazt az infrastruktúrát igényli, mint egy nyüzsgő étterem vagy egy magánrendelő.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            <p>
                Mi az Épületaudio-nál nem kész termékdobozokat adunk el, hanem komplett, helyszínre méretezett rendszereket tervezünk és kivitelezünk.
            </p>
        </div>
    </section>

    <section class="py-20 bg-petrol-50">
        <div class="mx-auto max-w-5xl px-6">
            <h2 class="font-display text-3xl font-semibold text-ink text-center" data-animate="split-up">Miért nem működik a "dobozos" hangtechnika?</h2>
            <p class="mt-4 text-ink/60 text-center max-w-2xl mx-auto" data-animate="fade-up">
                Amikor egy kivitelező sablonos szetteket próbál ráerőltetni egy épületre, annak szinte mindig ugyanaz a vége:
            </p>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-6" data-animate-group>
                @foreach ([
                    'Zavaró visszhang és gerjedés a nehéz akusztikájú terekben.',
                    'Egyenetlen hangerő: a hangszóró alatt elviselhetetlenül hangos, három méterrel arrébb viszont érthetetlen a beszéd.',
                    'Bonyolult, átláthatatlan kezelőfelületek, amiket a személyzet nem tud vagy nem mer használni.',
                    'Bővíthetetlen hálózat, ami az első átalakításnál cserére szorul.',
                ] as $problem)
                    <div class="flex items-start gap-3 rounded-2xl bg-white p-6 shadow-sm" data-animate-item>
                        <svg class="w-5 h-5 mt-0.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" /></svg>
                        <span class="text-ink/80">{{ $problem }}</span>
                    </div>
                @endforeach
            </div>

            <p class="mt-10 text-center text-ink/70 max-w-2xl mx-auto" data-animate="fade-up">
                Mi a kezdetektől fogva a 100V-os és a professzionális telepített hangtechnika törvényszerűségeire építünk: mérésekkel, pontos teljesítmény-számítással és helyszíni felméréssel biztosítjuk az egyenletes lefedettséget.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-5xl px-6">
            <h2 class="font-display text-3xl font-semibold text-ink text-center" data-animate="split-up">Hogyan születik meg az Ön egyedi rendszere?</h2>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-10" data-animate-group>
                @foreach ([
                    [
                        'title' => 'Helyszíni felmérés és akusztikai méretezés',
                        'description' => 'Nem találgatunk. Megvizsgáljuk a terek méretét, a falak és burkolatok anyagát, a háttérzajt és a hasznosítási célt. Kiszámoljuk a szükséges hangszórók számát, típusát és a beszédérthetőségi tényezőket.',
                    ],
                    [
                        'title' => 'Zónázott rendszertervezés',
                        'description' => 'Olyan architektúrát építünk fel, ahol a terek külön-külön vezérelhetők. A recepció, a raktár, az iroda vagy a terasz mind saját hangerő- és műsorforrás-szabályozást kap — szükség esetén integrált vészhangosító vagy ablakátbeszélő funkciókkal.',
                    ],
                    [
                        'title' => 'Szakipari kivitelezés & Rack-szerelés',
                        'description' => 'Ipari sztenderdeknek megfelelő, üzembiztos komponensekkel dolgozunk. A kábelezést esztétikusan, rejtve vezetjük, a központi egységeket pedig átlátható, szabványos rack szekrényekbe építjük be.',
                    ],
                    [
                        'title' => 'Beszabályozás és átadás',
                        'description' => 'Nem hagyjuk magára a rendszert az utolsó kábel bekötése után. A zónákat precízen beállítjuk, teszteljük a beszédérthetőséget, és betanítjuk a személyzetet az egyszerű, intuitív használatra.',
                    ],
                ] as $index => $step)
                    <div class="flex gap-5" data-animate-item>
                        <span class="font-display text-3xl font-semibold text-petrol-300 shrink-0">{{ sprintf('%02d', $index + 1) }}</span>
                        <div>
                            <h3 class="font-semibold text-ink">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-sm text-ink/60">{{ $step['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-5xl px-6">
            <h2 class="font-display text-3xl font-semibold text-cream text-center" data-animate="split-up">Miben mérjük a sikerünket?</h2>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-10 text-center" data-animate-group>
                @foreach ([
                    ['title' => '0–24 órás üzembiztonság', 'description' => 'Rendszereinket úgy tervezzük, hogy az év 365 napján folyamatosan, meghibásodás nélkül tegyék a dolgukat.'],
                    ['title' => 'Kristálytiszta beszédérthetőség', 'description' => 'Legyen szó hívórendszerről, konferenciáról vagy templomi igéről, a hang minden ponton érthető marad.'],
                    ['title' => 'Láthatatlan jelenlét', 'description' => 'A jó telepített hangtechnika észrevétlenül simul be az építészeti környezetbe, miközben tökéletes élményt nyújt.'],
                ] as $metric)
                    <div data-animate-item>
                        <h3 class="font-display text-xl font-semibold text-cream">{{ $metric['title'] }}</h3>
                        <p class="mt-3 text-sm text-cream/60">{{ $metric['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-band
        :title="'Készen áll az Ön épületéhez illő rendszer megtervezésére?'"
        :subtitle="'Ne kísérletezzen sablonos megoldásokkal. Kérjen helyszíni felmérést, és tervezzük meg együtt az épületéhez legközelebb álló audio infrastruktúrát!'"
    />
</x-layouts.app>
