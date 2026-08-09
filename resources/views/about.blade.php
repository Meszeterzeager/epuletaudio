<x-layouts.app :title="'Rólunk'">
    <x-slot:schema>
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Rólunk', 'url' => route('about')],
        ]" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Rólunk</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Az Épületaudio csapata épülethangosítási és konferenciatechnikai rendszerek tervezésével és kivitelezésével foglalkozik — a felméréstől az átadásig.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            <p>
                Célunk, hogy minden helyszínre — legyen az templom, rendelő, kávézó vagy közintézmény — a helyi
                adottságokhoz igazított, megbízható hangtechnikai megoldást tervezzünk, ami hosszú távon
                karbantartható és bővíthető marad.
            </p>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
