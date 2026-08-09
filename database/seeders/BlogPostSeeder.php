<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'slug' => 'akusztikai-felmeres-hangositas-elott',
                'title' => 'Miért fontos a helyszíni akusztikai felmérés hangosítás előtt?',
                'excerpt' => 'A legjobb hangfal is rossz hangzást ad rossz helyen. Bemutatjuk, mire figyelünk egy felmérés során, és miért nem lehet ezt a lépést kihagyni.',
                'published_at' => now()->subDays(28),
                'body' => <<<'HTML'
                    <p>Egy hangosítási projekt sikere nem a hangfalak márkáján vagy a wattszámon dől el elsősorban, hanem azon, hogy a rendszert a helyiség akusztikai adottságaihoz igazítva tervezték-e meg. Egy magas, kőpadlós templom és egy alacsony belmagasságú, szőnyeggel bélelt tárgyalóterem teljesen más megközelítést igényel — ugyanaz a hangfalpár az egyik helyen kristálytiszta beszédérthetőséget ad, a másikban visszhangos, érthetetlen zajt.</p>

                    <h2>Mit vizsgálunk a felmérés során</h2>
                    <ul>
                        <li><strong>Utózengési idő (RT60):</strong> mennyi ideig "él tovább" a hang a teremben, miután a forrás elhallgatott.</li>
                        <li><strong>Felületek anyaga:</strong> a kemény, sík felületek (üveg, kő, csempézett fal) visszaverik, a puha, szabálytalan felületek (szövet, szőnyeg, bútor) elnyelik a hangot.</li>
                        <li><strong>Helyiség geometriája:</strong> a párhuzamos falak és a kupolás mennyezet jellegzetes visszhang- és lebegésjelenségeket okoznak, amit már a hangfalak elhelyezésével is enyhíteni lehet.</li>
                        <li><strong>Háttérzaj:</strong> légkondicionáló, forgalom, szomszédos helyiségek — ezekhez kell méretezni a hangnyomásszintet, nem pedig egy elméleti "csendes" állapothoz.</li>
                    </ul>

                    <h2>Mi történik, ha kihagyjuk ezt a lépést</h2>
                    <p>A leggyakoribb hiba, amit látunk: a hangosítást kizárólag a helyiség alapterülete vagy a hangfal katalógusadatai alapján tervezik meg, a valós akusztikai viselkedés vizsgálata nélkül. Az eredmény tipikusan túlzott hangnyomás, visszhangos beszédérthetőség, vagy éppen ellenkezőleg — "halott", élettelen hangzás egy amúgy hangulatos térben.</p>

                    <p>A felmérés nem luxus, hanem a tervezési folyamat első és legfontosabb lépése — ez határozza meg, hány hangfalra, milyen elhelyezésre és milyen típusú rendszerre (pl. <a href="/megoldasok">iparág-specifikus megoldás</a>) lesz szükség.</p>
                    HTML,
            ],
            [
                'slug' => '100v-rendszer-vagy-alacsony-impedancia',
                'title' => '100V rendszer vagy alacsony impedanciás hangosítás — mikor melyiket válasszuk?',
                'excerpt' => 'Sok hangfal, hosszú kábelezés, egyszerű zónavezérlés? Vagy inkább néhány pontosan méretezett hangfal maximális hangminőséggel? Segítünk dönteni.',
                'published_at' => now()->subDays(21),
                'body' => <<<'HTML'
                    <p>A hangosítási rendszerek tervezésénél az egyik legfontosabb korai döntés, hogy 100V-os (más néven "PA" vagy transzformátoros) technológiát, vagy alacsony impedanciás (low-Z), hagyományos erősítős kialakítást választunk. A kettő nem egymást kizáró, hanem eltérő felhasználási esetre optimalizált megoldás.</p>

                    <h2>100V rendszer</h2>
                    <p>A 100V-os rendszerben minden hangfalban van egy kis transzformátor, ami lehetővé teszi, hogy sok hangfalat (akár 20-30 darabot is) kössünk egyetlen erősítőre, hosszú kábelezéssel, jelentős veszteség nélkül. Ez a technológia ideális:</p>
                    <ul>
                        <li>nagy alapterületű épületekhez (üzemek, áruházak, közösségi terek),</li>
                        <li>zónánkénti bemondásra és háttérzenére, ahol nem a hangminőség a legfontosabb, hanem a lefedettség és a beszédérthetőség,</li>
                        <li>ahol egyszerű, központi vezérlésre és bővíthetőségre van szükség.</li>
                    </ul>

                    <h2>Alacsony impedanciás (low-Z) rendszer</h2>
                    <p>Ebben az esetben az erősítő közvetlenül, transzformátor nélkül hajtja meg a hangfalakat — kevesebb hangfalat lehet egy erősítőre kötni, de a hangminőség és a dinamikatartomány jelentősen jobb. Ez a választás indokolt:</p>
                    <ul>
                        <li>koncertteremben, rendezvénytechnikában, ahol a zene minősége kritikus,</li>
                        <li>kisebb, néhány hangfalas kávézó vagy vendéglátóhely esetén,</li>
                        <li>ahol a hangfalak száma eleve kevés, így a 100V technológia előnyei (hosszú kábelezés, sok végpont) nem jelentenek valós nyereséget.</li>
                    </ul>

                    <h2>A gyakorlatban gyakran vegyesen alkalmazzuk</h2>
                    <p>Sok projektben a kettő kombinációja a legjobb megoldás: a háttérzene- és bemondás-zónák 100V rendszeren futnak, míg a fő rendezvénytérben egy dedikált, low-Z hangfalpár biztosítja a jobb hangminőséget élő eseményekhez. A megfelelő kombináció mindig a felméréstől és a felhasználási céltól függ.</p>
                    HTML,
            ],
            [
                'slug' => 'konferenciaterem-hangtechnika-alapok',
                'title' => 'Konferenciateremek hangtechnikája: mikrofon, keverő, DSP alapok',
                'excerpt' => 'Egy jó konferenciarendszer nem csak "felerősíti" a hangot — érthetőséget, visszhangmentességet és egyszerű kezelhetőséget is biztosít. Az alapokat mutatjuk be.',
                'published_at' => now()->subDays(14),
                'body' => <<<'HTML'
                    <p>Egy tárgyaló vagy konferenciaterem hangtechnikájának célja alapvetően eltér egy hangosítási rendszerétől: itt nem a nagy hangnyomás a cél, hanem a tiszta, visszhangmentes beszédérthetőség — gyakran több mikrofonos, esetleg videokonferenciás összeköttetésben.</p>

                    <h2>A rendszer főbb elemei</h2>
                    <ul>
                        <li><strong>Mikrofonok:</strong> asztali, mennyezeti (boundary) vagy gooseneck kivitelben — a választás a terem elrendezésétől és az esztétikai igényektől függ.</li>
                        <li><strong>Digitális keverő / DSP processzor:</strong> ez végzi a visszhang-elnyomást (AEC), az automatikus mikrofon-keverést és a hangszintek kiegyenlítését, hogy ne kelljen kézzel állítani minden megbeszélés előtt.</li>
                        <li><strong>Hangfalak vagy hangsugárzó panelek:</strong> jellemzően mennyezetbe süllyesztve, egyenletes lefedettséggel, hogy minden ülőhelyen azonos hangerő és érthetőség legyen.</li>
                    </ul>

                    <h2>Miért kritikus az akusztikai visszhang-elnyomás (AEC)</h2>
                    <p>Ha a teremben egyszerre több mikrofon és hangfal működik, a hangfalból kijövő hang visszakerülhet a mikrofonba, ami visszhangot vagy sípolást (visítást) okoz — ez az egyik leggyakoribb panasz rosszul megtervezett rendszereknél. A modern DSP processzorok ezt automatikusan kezelik, de csak akkor, ha a rendszert eleve ennek megfelelően, megfelelő mikrofon-hangfal távolsággal és szinttel tervezték meg.</p>

                    <h2>Videokonferencia-integráció</h2>
                    <p>Ma már a legtöbb konferenciarendszer nem önmagában, hanem Teams, Zoom vagy Google Meet integrációban működik. Ez azt jelenti, hogy a hangtechnikának USB vagy hálózati kapcsolaton keresztül is együtt kell működnie a laptoppal vagy a teremben telepített konferenciaegységgel — ezt már a tervezés fázisában figyelembe kell venni.</p>
                    HTML,
            ],
            [
                'slug' => 'tourguide-rendszerek-mikor-eri-meg',
                'title' => 'Tourguide rendszerek: mikor éri meg vezetett túrákhoz beruházni?',
                'excerpt' => 'Zajos üzemi bejáráson vagy nagy létszámú vezetett túrán a hagyományos "kiabálva magyarázás" nem működik. Bemutatjuk, hogyan segít egy tourguide rendszer.',
                'published_at' => now()->subDays(7),
                'body' => <<<'HTML'
                    <p>A tourguide (idegenvezető-) rendszerek egy vezetőmikrofonból és a résztvevők számára biztosított kis vevő-fejhallgató egységekből állnak. Bár elsőre "csak" turisztikai attrakciókhoz kötődő megoldásnak tűnhet, a gyakorlatban számos más helyzetben is jelentős előnyt jelent.</p>

                    <h2>Kiknek éri meg</h2>
                    <ul>
                        <li><strong>Üzemi bejárások:</strong> zajos gyártócsarnokban a vezető normál hangerővel, a résztvevők pedig tisztán, a háttérzajtól függetlenül hallják a magyarázatot.</li>
                        <li><strong>Múzeumok, kiállítóterek:</strong> egyszerre több csoport mozoghat egymás mellett anélkül, hogy zavarnák egymást.</li>
                        <li><strong>Épületbejárások, ingatlanbemutatók:</strong> a vezető természetes hangerővel beszélhet, nem kell "túlkiabálnia" a teret.</li>
                        <li><strong>Oktatási intézmények:</strong> gyakorlati foglalkozásokon, laborbemutatókon a tanár hangja a teljes csoporthoz egyenletesen eljut.</li>
                    </ul>

                    <h2>Mit kell tudni a technikáról</h2>
                    <p>A modern tourguide rendszerek digitális, licencmentes rádiófrekvencián működnek, egy vezető egységgel és általában 10-50 vevő egységgel (a csoport méretétől függően). A vevők könnyűek, egyszerűen kezelhetők, és higiéniai okokból cserélhető fülpárnával rendelkeznek. A rendszer akkumulátoros, így telepítés nélkül, mobilan is használható — ezért gyakran a mobil hangosítási megoldásaink kiegészítőjeként ajánljuk.</p>

                    <h2>Megtérülés</h2>
                    <p>Bár elsőre beruházásnak tűnik, rendszeres, ismétlődő vezetett túrák vagy bejárások esetén gyorsan megtérül: kevesebb a félreértés, rövidebbek a bejárások, és a résztvevők elégedettsége is nő, mivel valóban érthetik, amit a vezető mond.</p>
                    HTML,
            ],
            [
                'slug' => '5-gyakori-hiba-epulethangositasnal',
                'title' => '5 gyakori hiba épülethangosítási projekteknél — és hogyan kerüljük el őket',
                'excerpt' => 'A legtöbb hangosítási probléma nem a berendezés hibája, hanem tervezési hiba. Összeszedtük az öt leggyakoribbat.',
                'published_at' => now()->subDays(2),
                'body' => <<<'HTML'
                    <p>Évek óta végzünk épülethangosítási projekteket templomoktól kávézókig, és a hibák túlnyomó része néhány visszatérő mintát követ. Ha ezeket elkerüljük, a rendszer nemcsak jobban szól, hosszú távon is kevesebb karbantartást igényel.</p>

                    <h2>1. A hangfalak száma és teljesítménye nincs a térhez méretezve</h2>
                    <p>Kevés, túl erős hangfal éppúgy problémát okoz, mint sok, alulméretezett egység: az első visszhangot és egyenetlen lefedettséget, a második halk, érthetetlen hangzást ad. A megoldás mindig a helyszíni felmérésből induló, zónánkénti tervezés.</p>

                    <h2>2. Nincs zónavezérlés</h2>
                    <p>Egy nagyobb épületben (templom, iroda, intézmény) nem mindenhol kell egyszerre és egyforma hangerővel szólnia a rendszernek. A zónavezérlés hiánya azt jelenti, hogy egy bemondás vagy háttérzene feleslegesen zavarja azokat a területeket, ahol nincs rá szükség.</p>

                    <h2>3. Rossz kábelezés vagy alulméretezett kábelkeresztmetszet</h2>
                    <p>Hosszú hangfalvezetékeknél a nem megfelelő kábelkeresztmetszet jelentős teljesítményveszteséget és hangminőség-romlást okoz — ez az egyik leggyakoribb, utólag nehezen javítható hiba, mert a kábelezés jellemzően a fal vagy álmennyezet mögé kerül.</p>

                    <h2>4. A mikrofonos bemondó egység elhelyezése nincs átgondolva</h2>
                    <p>Ha a bemondó mikrofon túl közel van egy hangfalhoz, vagy rossz irányba néz, visszhangot és sípolást okozhat. Ezt már a tervezési fázisban figyelembe kell venni, nem utólag próbálni javítani.</p>

                    <h2>5. Nincs dokumentáció és betanítás az átadáskor</h2>
                    <p>Egy jól megtervezett rendszer is használhatatlanná válik, ha a személyzet nem tudja, hogyan kapcsolja be a megfelelő zónát, vagy hogyan állítsa be a hangerőt. Az átadás részeként mindig dokumentációt és rövid betanítást biztosítunk, hogy a rendszer hosszú távon is a tervezett módon működjön.</p>
                    HTML,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
