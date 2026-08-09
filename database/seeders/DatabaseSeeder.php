<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Solution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $services = [
            [
                'slug' => 'epulethangositas',
                'title' => 'Épülethangosítás',
                'short_description' => 'Egyenletes hangzás minden helyiségben, zónánként vezérelve — 100V-os technológiával nagy kiterjedésű épületekhez.',
                'order' => 1,
                'description' => "Egy épület hangja ugyanolyan része az identitásának, mint a homlokzata vagy a belsőépítészete. Az épülethangosítás nálunk nem egyenlő azzal, hogy \"felszerelünk néhány hangfalat\" — minden projekt a helyszín akusztikai felmérésével kezdődik, mert egy templom, egy irodaház és egy áruház gyökeresen más megközelítést kíván.\n\nA rendszereket úgy tervezzük meg, hogy zónánként, egymástól függetlenül vezérelhetők legyenek: a recepción szóló háttérzene nem zavarja a szomszédos tárgyalót, a bemondás pedig pontosan azt a szárnyat éri el, ahol szükség van rá. Nagy kiterjedésű épületeknél 100V-os technológiát alkalmazunk, ami lehetővé teszi, hogy akár több tucat hangfalat kössünk egyetlen erősítőre, hosszú kábelezéssel, jelentős veszteség nélkül.\n\nAz eredmény: egy rendszer, amit könnyű kezelni, egyszerű bővíteni, és — a legfontosabb — amit a bent dolgozók és a betérő vendégek egyszerűen csak jól hallanak, anélkül hogy tudatosulna bennük, miért.",
            ],
            [
                'slug' => 'konferenciarendszerek',
                'title' => 'Konferenciarendszerek',
                'short_description' => 'Tárgyalók, tantermek, üléstermek hang- és mikrofontechnikája.',
                'order' => 2,
                'description' => "Egy jó tárgyaló nem attól jó, hogy szép az asztal — attól, hogy mindenki tisztán hallja, amit a szemközti oldalon mondanak, visszhang és sípolás nélkül, videokonferencia esetén a távoli résztvevőkkel együtt is.\n\nA konferenciarendszereinket mikrofonból, digitális keverő/DSP-processzorból és pontosan méretezett hangfalakból építjük fel. A DSP feladata a visszhang-elnyomás és az automatikus mikrofon-keverés, hogy a teremben ne kelljen senkinek gombokat nyomkodnia egy megbeszélés közepén — csak leülnek, és működik.\n\nAkár egy kis tárgyalóról, akár egy nagy üléstermi rendszerről van szó Teams vagy Zoom integrációval, a cél ugyanaz: a technika legyen láthatatlan, a kommunikáció legyen tökéletes.",
            ],
            [
                'slug' => 'tourguide-rendszerek',
                'title' => 'Tourguide-rendszerek',
                'short_description' => 'Vezetett túrákhoz, üzemi bejárásokhoz szükséges audio megoldások.',
                'order' => 3,
                'description' => "Zajos gyártócsarnokban, egy zsúfolt kiállítóteremben vagy egy nagy létszámú épületbejáráson a hagyományos \"kiabálva magyarázás\" egyszerűen nem működik — a vezető hangja elvész, a hátul állók lemaradnak, mindenki fárad.\n\nA tourguide-rendszer egy vezetőmikrofonból és könnyű, higiénikusan cserélhető fülpárnás vevőegységekből áll. A vezető természetes hangerővel beszélhet, a résztvevők pedig — akár 50 méteres távolságból is — kristálytisztán hallják, licencmentes digitális rádiófrekvencián.\n\nMúzeumoknak, üzemi bejárásoknak, ingatlanbemutatóknak és oktatási intézményeknek egyaránt ajánljuk: a rendszer akkumulátoros, telepítés nélkül, azonnal használható, és a mobil hangosítási megoldásainkkal is remekül kombinálható.",
            ],
            [
                'slug' => 'mobil-hangositas',
                'title' => 'Mobil hangosítás',
                'short_description' => 'Rendezvényekre, alkalmi eseményekre telepíthető hangtechnika.',
                'order' => 4,
                'description' => "Nem minden hangosítási igény állandó. Egy céges rendezvény, egy szabadtéri esküvő, egy alkalmi konferencia vagy egy piactéri program mind olyan helyzet, ahol a hangtechnikának egy napra — vagy néhány órára — kell tökéletesen működnie, aztán ugyanolyan gyorsan el is kell tűnnie.\n\nMobil hangosítási megoldásainkat pontosan ehhez terveztük: kompakt, professzionális hangfalak és erősítők, amiket gyorsan felállítunk, belőnk a helyszínhez, és — igény esetén — a rendezvény alatt kezelünk is, hogy neked ne kelljen a technikával foglalkoznod.\n\nAkár beszédhez, akár élő zenéhez, akár csak háttérhangzáshoz kell megbízható rendszer, nálunk a helyszíni felméréstől a lebontásig minden egy kézben van.",
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        Service::where('slug', '100v-technologia')->delete();

        $solutions = [
            [
                'slug' => 'templomok',
                'industry_name' => 'Templomok',
                'order' => 1,
                'description' => 'A templomi terek nagy belmagassága, kemény, hangvisszaverő felületei (kő, üveg, csempézett fal) és a hosszú utózengési idő miatt a hangosítás elsődleges célja a beszédérthetőség biztosítása anélkül, hogy a tér akusztikai jellegét megbontanánk.',
                'challenges' => [
                    'Nagy belmagasság, hosszú utózengési idő',
                    'Kemény, hangvisszaverő felületek (kő, üveg)',
                    'Egyenetlen lefedettség a padsorok mélyén',
                    'Esztétikai elvárás — a hangfalak ne törjék meg a tér jellegét',
                ],
                'recommended_package' => [
                    '100V hangfalak, zónánként elosztva',
                    'Zónavezérlő egység (szentély, hajó, kórus külön hangerővel)',
                    'Mikrofonos bemondó/liturgikus pult',
                    'Diszkrét, tér-illő hangfal kivitelek',
                ],
            ],
            [
                'slug' => 'fogaszatok-rendelok',
                'industry_name' => 'Fogászatok, rendelők',
                'order' => 2,
                'description' => 'Fogászati és orvosi rendelőkben a hangosítás célja a nyugtató, diszkrét háttérzene biztosítása, ami oldja a várakozás és a kezelés alatti feszültséget, de nem zavarja a személyzet és a páciensek közti kommunikációt.',
                'challenges' => [
                    'Nyugtató háttérzene zónánként (recepció, váró, kezelő)',
                    'Alacsony hangnyomás, diszkrét megjelenés',
                    'Higiéniai és helykorlátok a hangfal elhelyezésénél',
                    'Egyszerű kezelhetőség a recepció részéről',
                ],
                'recommended_package' => [
                    'Kis méretű, mennyezetbe süllyeszthető hangfalak',
                    'Zónánkénti hangerő-szabályzás',
                    'Streaming/lejátszó integráció (Spotify, helyi lejátszó)',
                    'Egyszerű, egy gombos kezelőfelület',
                ],
            ],
            [
                'slug' => 'kavezok-vendeglatas',
                'industry_name' => 'Kávézók, vendéglátás',
                'order' => 3,
                'description' => 'Vendéglátóhelyeken a hangosítás elsődleges szerepe a hangulatteremtés, ugyanakkor a zajszint és a beszélgetést zavaró hangerő közti egyensúlyt is kezelni kell — különösen nyitott, sok kemény felületű terekben.',
                'challenges' => [
                    'Hangulat és zajszint egyensúlya',
                    'Nyitott terek, egyenetlen lefedettség',
                    'Esztétikai igény — a hangfal illeszkedjen a belsőépítészethez',
                    'Zsúfolt időszakokban automatikus hangerő-kompenzáció igénye',
                ],
                'recommended_package' => [
                    'Design hangfalak, rejtett vagy stílusba illő kivitelben',
                    'Streaming-integráció (Spotify, Apple Music)',
                    'Zajszint-érzékelős automatikus hangerő-szabályzás',
                    'Zónánkénti lejátszás (terasz, belső tér külön vezérelve)',
                ],
            ],
            [
                'slug' => 'kozuletek-intezmenyek',
                'industry_name' => 'Közületek, intézmények',
                'order' => 4,
                'description' => 'Közületeknél és nagyobb intézményeknél (irodák, oktatási intézmények, önkormányzatok) a hangosítás legfontosabb szempontja a központi vezérlés, a könnyű bővíthetőség és a megbízható, sok végpontra kiterjedő lefedettség.',
                'challenges' => [
                    'Sok helyiség, egységes központi vezérlés igénye',
                    'Zónánkénti bemondás és riasztás szükségessége',
                    'Hosszú távú bővíthetőség (új szárny, új terem)',
                    'Egyszerű kezelhetőség a portaszolgálat vagy recepció részéről',
                ],
                'recommended_package' => [
                    '100V rendszer, központi erősítővel',
                    'Zónavezérlő és ütemezhető bemondó szoftver',
                    'Központi mikrofonos bemondó pult',
                    'Bővíthető kábelinfrastruktúra új zónákhoz',
                ],
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::updateOrCreate(['slug' => $solution['slug']], $solution);
        }

        $this->call(BlogPostSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
