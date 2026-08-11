<x-layouts.app :title="'Általános Szerződési Feltételek'">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Általános Szerződési Feltételek', 'url' => route('legal.terms')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Általános Szerződési Feltételek</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Hatályos: 2026. augusztus 11-től
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            <h2>1. Az Üzemeltető adatai</h2>
            <ul>
                <li><strong>Cégnév / Egyéni vállalkozó neve:</strong> {{ config('company.legal_name') }}</li>
                <li><strong>Székhely:</strong> {{ config('company.address') }}</li>
                <li><strong>Adószám:</strong> {{ config('company.tax_number') }}</li>
                <li><strong>Nyilvántartási szám:</strong> {{ config('company.registration_number') }}</li>
                <li><strong>E-mail cím:</strong> <a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                <li><strong>Telefonszám:</strong> {{ config('company.phone') }}</li>
                <li><strong>Tárhelyszolgáltató adatai:</strong> {{ config('company.hosting_name') }} ({{ config('company.hosting_address') }}, {{ config('company.hosting_email') }})</li>
            </ul>

            <h2>2. A weboldal célja és jogi jellege</h2>
            <ol>
                <li>A jelen weboldal (<code>epuletaudio.hu</code>) az Üzemeltető által nyújtott épülethangosítási, akusztikai, vészhangosítási és konferenciatechnikai szolgáltatások, valamint kapcsolódó termékek bemutatására szolgál.</li>
                <li>A weboldalon található információk, leírások, műszaki paraméterek és esetleges indikatív árak kizárólag tájékoztató jellegűek, nem minősülnek a Polgári Törvénykönyv (Ptk.) szerinti közvetlen ajánlattételnek.</li>
                <li>A weboldalon keresztül közvetlen online adásvétel, kosárelhelyezés vagy azonnali fizetés nem történik.</li>
            </ol>

            <h2>3. Az ajánlatkérés és a szerződéskötés menete</h2>
            <ol>
                <li>A Látogató a weboldalon található űrlapok, e-mail cím vagy telefonszám segítségével ajánlatot kérhet az Üzemeltetőtől.</li>
                <li>Az ajánlatkérés elküldése nem hoz létre fizetési kötelezettséggel járó szerződést.</li>
                <li>Az Üzemeltető a megkeresést követően egyeztet a Megrendelővel (szükség esetén helyszíni felmérést végez), majd egyedi, írásos árajánlatot ad ki.</li>
                <li>A felek közötti jogviszony és az egyedi kivitelezési/szállítási szerződés az egyedi árajánlat írásbeli elfogadásával és/vagy a külön szolgáltatási szerződés aláírásával jön létre.</li>
            </ol>

            <h2>4. Szellemi tulajdonjogok</h2>
            <ol>
                <li>A weboldal teljes tartalma (szövegek, grafikák, rendszerdiagramok, logók, képek, elrendezés) az Üzemeltető kizárólagos szellemi tulajdonát képezi.</li>
                <li>A weboldal tartalmának bármilyen formában történő másolása, átdolgozása, terjesztése vagy üzleti célú felhasználása kizárólag az Üzemeltető előzetes, írásbeli hozzájárulásával engedélyezett.</li>
            </ol>

            <h2>5. Felelősségkorlátozás</h2>
            <ol>
                <li>Az Üzemeltető megtesz mindent a weboldalon található adatok pontosságáért, de nem vállal felelősséget az esetleges elírásokból, technikai hibákból vagy az oldalt kiszolgáló szerverek leállásából eredő közvetett károkért.</li>
                <li>Az Üzemeltető fenntartja a jogot a weboldal tartalmának előzetes értesítés nélküli módosítására vagy frissítésére.</li>
            </ol>

            <p>
                Adatkezeléssel kapcsolatos kérdéseivel keresse fel az
                <a href="{{ route('legal.privacy') }}" wire:navigate>Adatkezelési Tájékoztatót</a>.
            </p>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
