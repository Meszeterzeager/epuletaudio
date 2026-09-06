@php
    $faqItems = [
        [
            'question' => 'Mennyibe kerül egy épülethangosítási rendszer?',
            'answer' => 'Az ár mindig a helyszíntől, a tér méretétől és a kért rendszertípustól függ. Ha kitöltöd az <a href="'.route('quote.create').'" class="underline hover:text-petrol-900">ajánlatkérő űrlapunkat</a> — benne fotókkal, videókkal és alaprajzzal, ha van —, ez a legtöbb esetben elég ahhoz, hogy helyszíni felmérés nélkül is pontos ajánlatot adjunk; kiszállásra csak ritkán, valóban indokolt esetben van szükség, és az nem díjmentes.',
        ],
        [
            'question' => 'Mennyi idő alatt készül el egy hangosítási projekt?',
            'answer' => 'A felméréstől a tervezésen át a telepítésig egy kisebb rendelő esetén néhány hét, egy nagyobb intézménynél (iskola, templom, ipari csarnok) néhány hónap is lehet, a rendszer méretétől és az ütemtervtől függően.',
        ],
        [
            'question' => 'Milyen épülettípusokhoz vállalnak munkát?',
            'answer' => 'Templomoknak, egészségügyi rendelőknek, vendéglátóhelyeknek és hoteleknek, irodáknak és konferenciatermeknek, kereskedelmi egységeknek és showroomoknak, oktatási és közintézményeknek, ipari csarnokoknak és raktáraknak, valamint sportlétesítményeknek egyaránt — nézd meg a <a href="'.route('solutions.index').'" class="underline hover:text-petrol-900">iparág szerinti megoldásainkat</a>.',
        ],
        [
            'question' => 'Mi a különbség a 100V-os és a hagyományos (low-Z) hangosítás között?',
            'answer' => 'A 100V-os rendszer sok hangfalat tesz lehetővé hosszú kábelezéssel, egyszerű zónavezérléssel — nagy épületekhez ideális. A hagyományos (low-Z) rendszer jobb hangminőséget ad, de kevesebb hangfalat és rövidebb kábelezést enged. Bővebben a <a href="'.route('blog.show', '100v-rendszer-vagy-alacsony-impedancia').'" class="underline hover:text-petrol-900">részletes cikkünkben</a>.',
        ],
        [
            'question' => 'Csak új telepítést vállalnak, vagy meglévő rendszer bővítését, javítását is?',
            'answer' => 'Meglévő rendszerek felmérését, bővítését és korszerűsítését is vállaljuk, nem csak új telepítést.',
        ],
        [
            'question' => 'Hogyan induljon el egy projekt?',
            'answer' => 'Küldd el a projekt adatait, fotókat/videókat és a pontos címet az <a href="'.route('quote.create').'" class="underline hover:text-petrol-900">ajánlatkérő űrlapunkon</a> — ez alapján a legtöbb esetben helyszíni felmérés nélkül is pontos ajánlatot tudunk adni, amit igény esetén egy (díjköteles) helyszíni felmérés vagy konzultáció követhet.',
        ],
    ];
@endphp

<section class="py-24 bg-petrol-50">
    <div class="mx-auto max-w-3xl px-6">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-500 text-center" data-animate="fade-up">Kérdésed van?</p>
        <h2 class="mt-2 font-display text-3xl font-semibold text-ink mb-12 text-center" data-animate="split-up">Gyakran ismételt kérdések</h2>

        <div class="divide-y divide-petrol-100 border-y border-petrol-100" data-animate-group>
            @foreach ($faqItems as $item)
                <details class="group py-6" data-animate-item>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-lg font-semibold text-ink [&::-webkit-details-marker]:hidden">
                        {{ $item['question'] }}
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-petrol-900 text-cream transition-transform duration-200 group-open:rotate-45">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 max-w-2xl text-ink/60 leading-relaxed">{!! $item['answer'] !!}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<x-schema.faq-page :items="$faqItems" />
