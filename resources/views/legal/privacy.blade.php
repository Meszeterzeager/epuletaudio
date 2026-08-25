<x-layouts.app :title="'Adatkezelési Tájékoztató'">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Adatkezelési Tájékoztató', 'url' => route('legal.privacy')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Adatkezelési Tájékoztató</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Hatályos: 2026. augusztus 11-től
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            <h2>1. Az Adatkezelő adatai</h2>
            <ul>
                <li><strong>Adatkezelő neve:</strong> {{ config('company.legal_name') }}</li>
                <li><strong>Székhely:</strong> {{ config('company.address') }}</li>
                <li><strong>Adószám:</strong> {{ config('company.tax_number') }}</li>
                <li><strong>E-mail:</strong> <a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                @if (config('company.phone'))
                    <li><strong>Telefonszám:</strong> {{ config('company.phone') }}</li>
                @endif
            </ul>

            <h2>2. A kezelt adatok köre, célja és jogalapja</h2>

            <h3>A) Kapcsolatfelvétel és Árajánlatkérés (Űrlapok, e-mail)</h3>
            <ul>
                <li><strong>Kezelt adatok:</strong> Név, e-mail cím, telefonszám, cégnév, a megkeresés/projekt leírása.</li>
                <li><strong>Adatkezelés célja:</strong> Kapcsolattartás, árajánlat készítése, műszaki egyeztetés, helyszíni felmérés megszervezése.</li>
                <li><strong>Jogalap:</strong> A GDPR 6. cikk (1) bekezdés b) pontja (szerződést megelőző lépések megtétele az érintett kérésére).</li>
                <li><strong>Adatmegőrzési idő:</strong> Az ajánlat érvényességi idejének lejártáig, vagy a létrejött szerződés teljesítésétől számított 5 évig (elévülési idő). Ajánlat elutasítása esetén az adatok 6 hónapon belül törlésre kerülnek.</li>
            </ul>

            <h3>B) Szerver naplózás és technikai adatok</h3>
            <ul>
                <li><strong>Kezelt adatok:</strong> IP-cím, böngésző típusa, látogatás időpontja, megtekintett oldalak.</li>
                <li><strong>Adatkezelés célja:</strong> A weboldal biztonságos működésének biztosítása, visszaélések kivédése.</li>
                <li><strong>Jogalap:</strong> A GDPR 6. cikk (1) bekezdés f) pontja (az Adatkezelő jogos érdeke).</li>
                <li><strong>Adatmegőrzési idő:</strong> 30 nap.</li>
            </ul>

            <h2>3. Adatfeldolgozók (Harmadik felek)</h2>
            <p>Az adatok kezelése során az Adatkezelő az alábbi adatfeldolgozókat veszi igénybe:</p>
            <ul>
                <li><strong>Tárhely- és e-mail szolgáltató:</strong> {{ config('company.hosting_name') }}, {{ config('company.hosting_address') }} (szerverinfrastruktúra biztosítása)</li>
                <li><strong>SMTP / E-mail küldő rendszer:</strong> Resend, Inc. (tranzakciós és értesítő e-mailek küldése)</li>
                <li><strong>Analitika</strong> (amennyiben használunk ilyet): Google Ireland Ltd. (anonimizált látogatottsági statisztikák)</li>
            </ul>

            <h2>4. Cookie-k (Sütik) használata</h2>
            <ol>
                <li><strong>Működéshez szükséges sütik:</strong> A weboldal alapvető funkcióinak biztosításához szükségesek (pl. munkamenet). Ezek használatához nem szükséges külön hozzájárulás.</li>
                <li><strong>Analitikai sütik:</strong> A látogatói élmény javítása érdekében anonim statisztikai adatokat gyűjtenek. Ezek használata a weboldalra érkezéskor a cookie-bannerben fogadható el vagy utasítható vissza.</li>
            </ol>

            <h2>5. Az érintettek jogai</h2>
            <p>A felhasználó bármikor jogosult:</p>
            <ul>
                <li>Tájékoztatást kérni a kezelt adatairól (hozzáférési jog).</li>
                <li>Kérni adatai helyesbítését vagy törlését ("elfeledtetéshez való jog").</li>
                <li>Kérni az adatkezelés korlátozását.</li>
                <li>Tiltakozni a jogos érdeken alapuló adatkezelés ellen.</li>
            </ul>
            <p>
                Jogai gyakorlásához az érintett a
                <a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a>
                címre küldhet kérelmet.
            </p>

            <h2>6. Jogorvoslati lehetőségek</h2>
            <p>Amennyiben az érintett úgy ítéli meg, hogy az Adatkezelő megsértette a személyes adatok védelméhez fűződő jogait, panasszal fordulhat a hatósághoz:</p>
            <ul>
                <li><strong>Nemzeti Adatvédelmi és Információszabadság Hatóság (NAIH)</strong></li>
                <li>Cím: 1055 Budapest, Falk Miksa utca 9-11.</li>
                <li>Levelezési cím: 1363 Budapest, Pf. 9.</li>
                <li>E-mail: <a href="mailto:ugyfelszolgalat@naih.hu">ugyfelszolgalat@naih.hu</a></li>
                <li>Web: <a href="https://naih.hu" target="_blank" rel="noopener">https://naih.hu</a></li>
            </ul>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
