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
                'short_description' => 'Egyenletes hangzás minden helyiségben, igény szerint akár zónánként külön vezérelve — 100V-os technológiával nagy kiterjedésű épületekhez.',
                'meta_title' => 'Épülethangosítás — 100V-os hangrendszer tervezés és telepítés',
                'meta_description' => 'Egyenletes hangzás templomoknak, irodáknak és intézményeknek, igény szerint zónánként vezérelve — alapos igényfelméréstől a 100V-os hangrendszer telepítéséig és átadásáig.',
                'order' => 1,
                'description' => "Egy épület hangja ugyanolyan része az identitásának, mint a homlokzata vagy a belsőépítészete. Az épülethangosítás nálunk nem egyenlő azzal, hogy \"felszerelünk néhány hangfalat\" — minden projekt alapos igényfelméréssel kezdődik, amit szükség esetén személyes helyszíni felméréssel vagy konzultációval is kiegészítünk, mert egy templom, egy irodaház és egy áruház gyökeresen más megközelítést kíván.\n\nA rendszereket úgy tervezzük meg, hogy igény szerint akár több zóna is egymástól függetlenül vezérelhető legyen — nem kell mindenhol külön zónákra bontani a rendszert, csak ott, ahol ennek valódi értelme van: a recepción szóló háttérzene így nem zavarja a szomszédos tárgyalót, a bemondás pedig pontosan azt a szárnyat éri el, ahol szükség van rá. Nagy kiterjedésű épületeknél 100V-os technológiát alkalmazunk, ami lehetővé teszi, hogy akár több tucat hangfalat kössünk egyetlen erősítőre, hosszú kábelezéssel, jelentős veszteség nélkül.\n\nAz eredmény: egy rendszer, amit könnyű kezelni, egyszerű bővíteni, és — a legfontosabb — amit a bent dolgozók és a betérő vendégek egyszerűen csak jól hallanak, anélkül hogy tudatosulna bennük, miért.",
            ],
            [
                'slug' => 'konferenciarendszerek',
                'title' => 'Konferenciarendszerek',
                'short_description' => 'Tárgyalók, tantermek, üléstermek hang- és mikrofontechnikája.',
                'meta_title' => 'Konferenciarendszerek — mikrofon, DSP és videokonferencia-integráció',
                'meta_description' => 'Visszhangmentes, tiszta beszédérthetőség tárgyalókban és tanácstermekben — mikrofon, digitális keverő és Teams/Zoom-kompatibilis konferenciatechnika.',
                'order' => 2,
                'description' => "Egy jó tárgyaló nem attól jó, hogy szép az asztal — attól, hogy mindenki tisztán hallja, amit a szemközti oldalon mondanak, visszhang és sípolás nélkül, videokonferencia esetén a távoli résztvevőkkel együtt is.\n\nA konferenciarendszereinket mikrofonból, digitális keverő/DSP-processzorból és pontosan méretezett hangfalakból építjük fel. A DSP feladata a visszhang-elnyomás és az automatikus mikrofon-keverés, hogy a teremben ne kelljen senkinek gombokat nyomkodnia egy megbeszélés közepén — csak leülnek, és működik.\n\nAkár egy kis tárgyalóról, akár egy nagy üléstermi rendszerről van szó Teams vagy Zoom integrációval, a cél ugyanaz: a technika legyen láthatatlan, a kommunikáció legyen tökéletes.",
            ],
            [
                'slug' => 'tourguide-rendszerek',
                'title' => 'Tourguide-rendszerek',
                'short_description' => 'Vezetett túrákhoz, üzemi bejárásokhoz szükséges audio megoldások.',
                'meta_title' => 'Tourguide rendszerek — vezetett túrákhoz és üzemi bejárásokhoz',
                'meta_description' => 'Zajos gyártócsarnokban vagy múzeumi vezetett túrán is tisztán érthető magyarázat — vezetőmikrofon és vezeték nélküli fülhallgató-vevők bérelhető és telepíthető rendszere.',
                'order' => 3,
                'description' => "Zajos gyártócsarnokban, egy zsúfolt kiállítóteremben vagy egy nagy létszámú épületbejáráson a hagyományos \"kiabálva magyarázás\" egyszerűen nem működik — a vezető hangja elvész, a hátul állók lemaradnak, mindenki fárad.\n\nA tourguide-rendszer egy vezetőmikrofonból és könnyű, higiénikusan cserélhető fülpárnás vevőegységekből áll. A vezető természetes hangerővel beszélhet, a résztvevők pedig — akár 50 méteres távolságból is — kristálytisztán hallják, licencmentes digitális rádiófrekvencián.\n\nMúzeumoknak, üzemi bejárásoknak, ingatlanbemutatóknak és oktatási intézményeknek egyaránt ajánljuk: a rendszer akkumulátoros, telepítés nélkül, azonnal használható, és a mobil hangosítási megoldásainkkal is remekül kombinálható.",
            ],
            [
                'slug' => 'mobil-hangositas',
                'title' => 'Mobil hangosítás',
                'short_description' => 'Kompakt, magától is összeszerelhető hangtechnika iskoláknak, céges és médiarendezvényekre, különleges alkalmakra.',
                'meta_title' => 'Mobil hangosítás — iskoláknak, rendezvényekre, alkalmi eseményekre',
                'meta_description' => 'Kompakt, egyszerűen összeszerelhető hangfal- és erősítő-szett iskoláknak, céges és médiarendezvényeknek — telepítés nélkül, pár perc alatt, szakértelem nélkül is használható.',
                'order' => 4,
                'description' => "Nem minden hangosítási igény állandó, és nem mindenhez kell telepítés. Egy iskolai rendezvény, egy céges esemény, egy médiafelvétel vagy egy különleges alkalom mind olyan helyzet, ahol elég, ha a hangtechnika egyszerűen és gyorsan összeáll, tökéletesen működik, aztán ugyanolyan könnyen szét is szedhető.\n\nMobil hangosítási rendszereinket pontosan erre terveztük: kompakt, professzionális hangfalakból és erősítőből álló, egyszerűen összeállítható szettek, amiket egy hozzáértő szakember nélkül is, pár perc alatt össze lehet dugni és használatba lehet venni — nincs szükség telepítésre, csak csatlakoztatásra.\n\nAjánljuk iskoláknak, céges és médiarendezvényekre, valamint különleges alkalmakra, ahol fontos az egyszerű kezelhetőség: akár beszédhez, akár háttérzenéhez kell megbízható hangzás, a rendszert bárki magabiztosan tudja kezelni.",
            ],
            [
                'slug' => 'ablak-atbeszelo-recepcio',
                'title' => 'Ablakátbeszélő rendszer recepciókra',
                'short_description' => 'Tiszta, érthető kommunikáció üveg- vagy plexi-válaszfal mögött — recepcióknak, pénztáraknak, portaszolgálatnak és biztonsági alkalmazásokra.',
                'meta_title' => 'Ablakátbeszélő (intercom) rendszer recepciókra és pultokra',
                'meta_description' => 'Tiszta kommunikáció üveg- vagy plexi-válaszfal mögött recepcióknak, pénztáraknak és portaszolgálatnak — gyors telepítés, pultátépítés nélkül, igény szerinti zónázással.',
                'order' => 6,
                'description' => "A biztonsági vagy higiéniai okból beépített üveg- és plexifal a recepciós pultoknál, pénztáraknál, portaszolgálatoknál és ügyfélszolgálatoknál egyre gyakoribb — csakhogy egy vastag üvegtábla mögött a normál beszéd elveszíti az érthetőségét, és mindkét fél kénytelen kiabálni vagy egy kis lyukhoz hajolni.\n\nAz ablakátbeszélő rendszer (más néven intercom) egy diszkrét, az üvegbe vagy a pult síkjába integrált mikrofon-hangszóró egységpárból áll, amely a hangot tisztán, torzítás nélkül, természetes hangerőn viszi át a válaszfalon — mindkét irányban, kéz felszabadítva, kontaktus nélkül. A vendég ugyanolyan könnyedén érti a recepcióst vagy a pénztárost, mintha nem is lenne köztük üveg.\n\nAjánljuk recepcióknak, pénztáraknak, portaszolgálatoknak, gyógyszertári és okmányiroda-jellegű pultoknak, valamint minden olyan biztonsági és ügyfélszolgálati pontnak, ahol a védőfal nem mehet a kommunikáció rovására. A telepítés gyors, nem igényel a pult átépítését, és igény esetén a meglévő hangosítási rendszerünkkel is összekapcsolható.\n\nTöbb pult vagy ablak esetén a rendszert zónánként is meg tudjuk tervezni, de ez nem kötelező — ha csak egyetlen pultnál van szükség az átbeszélésre, egy zóna is tökéletesen elég, nem kell minden helyiséget külön zónaként kezelni.",
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        Service::where('slug', '100v-technologia')->delete();
        Service::where('slug', 'veszhangositas-evakuacio')->delete();

        // Csak akkor töltjük vissza a hero_image-et, ha jelenleg üres — így egy
        // esetleges friss adatbázis-reset után is marad kép, de nem írja felül
        // az adminban időközben feltöltött valódi fotót.
        $serviceHeroImages = [
            'epulethangositas' => 'services/XEUTaWWHi3hc2VE0lIFiI0s5R5je7j4hDtiJt8NQ.webp',
            'konferenciarendszerek' => 'services/zkBHXD0CztGt6Ai50hTRCXmfQk6cMF5mvfMj2f10.webp',
            'tourguide-rendszerek' => 'services/uHqNENGydLnSLw0KG5qExyNe1p6Nb29COqf3SlV0.webp',
            'mobil-hangositas' => 'services/13hecgDqkFiXo4uSFCT5viRYg90IR0P4RzNtLXDV.webp',
            'ablak-atbeszelo-recepcio' => 'services/0dMMBprvNnGPAVpGUAHNKrTsKE1ioR7u4JWpsusV.webp',
        ];

        foreach ($serviceHeroImages as $slug => $heroImage) {
            Service::where('slug', $slug)->whereNull('hero_image')->update(['hero_image' => $heroImage]);
        }

        $solutions = [
            [
                'slug' => 'ipar-logisztika',
                'industry_name' => 'Ipari csarnokok & Raktárak',
                'meta_title' => 'Hangosítás ipari csarnokoknak és raktáraknak',
                'meta_description' => 'Nagy teljesítményű 100V-os rendszer zajos gyártócsarnokokhoz és logisztikai raktárakhoz — üzemi bemondás és vészjelzés minden zónában, tartós ipari kivitelben.',
                'order' => 1,
                'description' => "Egy nagy alapterületű gyártócsarnok vagy logisztikai raktár egészen más hangosítási feladat, mint egy iroda: a tér magas, zajos, sokszor poros vagy nedves környezet, és a bemondásnak több tíz vagy száz méteres távolságra is érthetően el kell jutnia mindenkihez.\n\nA rendszereket zónánként tervezzük — a rakodó, a raktár és az irodai rész külön hangerővel és külön bemondási móddal szólal meg —, nagy teljesítményű 100V-os végfokokkal és strapabíró, ipari környezetre tervezett tölcséres, illetve fali hangszórókkal. A cél, hogy egy vészhelyzeti vagy üzemi bemondás a legzajosabb gépsor mellett is tisztán hallható legyen, a háttérzene pedig ne vesszen el a csarnok zajában.\n\nAkár egy meglévő épület utólagos hangosításáról, akár egy tervezési fázisban lévő új csarnok rendszeréről van szó, a nagy távolságok és a mostoha környezeti körülmények miatt itt különösen fontos a helyszíni felmérés és a megfelelő hangnyomás-számítás.",
                'challenges' => [
                    'Nagy alapterület, nagy távolságok lefedése',
                    'Magas zajszint a gépek és a szellőzés miatt',
                    'Por, nedvesség, ipari környezeti terhelés',
                    'Vészhelyzeti bemondás érthetőségének biztosítása',
                ],
                'recommended_package' => [
                    'Nagy teljesítményű 100V-os Castone végfokok',
                    'Strapabíró, időjárás- és porálló Monacor tölcséres/fali hangszórók',
                    'Zónánkénti vezérlés (rakodó, raktár, iroda külön hangerővel)',
                    'Gombnyomásos vész- és üzemi bemondó mikrofon',
                ],
            ],
            [
                'slug' => 'kavezok-vendeglatas',
                'industry_name' => 'Vendéglátás & Hotelek',
                'meta_title' => 'Hangosítás vendéglátóhelyeknek és szállodáknak',
                'meta_description' => 'Hangulatteremtő, zónánként vezérelt zenei hangosítás éttermeknek, kávézóknak és hoteleknek — automatikus hangerő-szabályzással a zsúfolt időszakokra is.',
                'order' => 2,
                'description' => "Éttermekben, kávézókban és szállodákban a hangosítás legfontosabb szerepe a hangulatteremtés — úgy, hogy közben ne nehezítse meg a beszélgetést az asztaloknál vagy a recepción.\n\nA beltéri termeket, a teraszt és a szállodai közösségi tereket külön zónában, külön hangerővel és akár külön zenei playlistával szólaltatjuk meg, diszkrét fali vagy mennyezeti hangszórókkal, amik nem törik meg a belsőépítészeti koncepciót. Éttermeknél és szállodáknál gyakori igény az automatikus, zajszint-érzékelős hangerő-szabályzás is, hogy zsúfolt időszakban se kelljen kiabálni a zene fölött.\n\nSzállodáknál emellett a wellness, a bár és a rendezvényterem gyakran igényel önálló, a többitől függetlenül vezérelhető rendszert — ezt egy jól megtervezett többzónás mátrix keverővel oldjuk meg, amit a személyzet egyetlen kezelőfelületről irányíthat.",
                'challenges' => [
                    'Hangulat és zajszint egyensúlya zsúfolt időszakban is',
                    'Több zóna (belső tér, terasz, bár, wellness) önálló vezérlése',
                    'Esztétikai igény — a hangfal illeszkedjen a belsőépítészethez',
                    'Egyszerű, személyzet által kezelhető felület',
                ],
                'recommended_package' => [
                    'Design hangfalak, rejtett vagy stílusba illő kivitelben',
                    'Többzónás mátrix keverő, Bluetooth/IP műsorforrásokkal',
                    'Zajszint-érzékelős automatikus hangerő-szabályzás',
                    'Streaming-integráció (Spotify, Apple Music)',
                ],
            ],
            [
                'slug' => 'fogaszatok-rendelok',
                'industry_name' => 'Egészségügy & Magánrendelők',
                'meta_title' => 'Hangosítás fogászatoknak, rendelőknek és klinikáknak',
                'meta_description' => 'Nyugtató, diszkrét háttérzene és igény esetén beteghívó rendszer magánrendelőkbe és klinikákba — alacsony hangnyomás, süllyesztett hangfalak.',
                'order' => 3,
                'description' => "Fogászatokban, magánklinikákon és rendelőkben a hangosítás célja a nyugtató, diszkrét háttérzene és — igény esetén — a beteghívó rendszer, ami oldja a várakozás és a kezelés alatti feszültséget, de nem zavarja a személyzet és a páciensek közti kommunikációt.\n\nA várót, a recepciót és az egyes kezelőhelyiségeket külön zónában szólaltatjuk meg, alacsony hangnyomással, süllyesztett mennyezeti hangszórókkal, amik nem foglalnak helyet és higiéniailag is problémamentesek. A recepció egyetlen egyszerű kezelőfelületről állíthatja be a hangerőt és a lejátszott zenét, technikai háttértudás nélkül.\n\nNagyobb klinikáknál a beteghívó és a rendelőnkénti diszkrét jelzés is beépíthető a rendszerbe, így a hangosítás nemcsak a hangulatért, hanem a betegforgalom zökkenőmentes szervezéséért is felel.",
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
                    'Igény esetén beteghívó és diszkrét jelzőrendszer integrációja',
                ],
            ],
            [
                'slug' => 'irodak-konferencia',
                'industry_name' => 'Irodák & Konferenciatermek',
                'meta_title' => 'Hangosítás irodáknak és konferenciatermeknek',
                'meta_description' => 'Egyenletes háttérzene a közösségi terekben, visszhangmentes beszédérthetőség a tárgyalókban — Teams/Zoom-kompatibilis konferenciatechnikával.',
                'order' => 4,
                'description' => "Egy nyitott irodatérben vagy egy tárgyalóban a hangosítás két, egymással látszólag ellentétes célt szolgál: a közösségi terekben kellemes háttérzenét ad, a tárgyalókban és konferenciatermekben pedig tökéletes beszédérthetőséget biztosít — visszhang és sípolás nélkül, hibrid megbeszéléseken is.\n\nA nyitott irodaterekbe diszkrét, egyenletes lefedettséget adó mennyezeti hangszórókat tervezünk, míg a tárgyalókba és a konferenciatermekbe asztali vagy mennyezeti mikrofonokat, digitális DSP-processzort és pontosan méretezett hangfalakat építünk, amik automatikusan kezelik a visszhang-elnyomást és a mikrofonváltást.\n\nA cél mindkét esetben ugyanaz: a technika legyen láthatatlan, és senkinek ne kelljen gombokat nyomkodnia egy megbeszélés közepén — csak leül, és működik, akár helyi, akár Teams/Zoom megbeszélésről van szó.",
                'challenges' => [
                    'Nyitott iroda és zárt tárgyaló eltérő akusztikai igénye',
                    'Visszhang- és sípolásmentes beszédérthetőség hibrid megbeszéléseken',
                    'Egyszerű, egy gombos kezelhetőség minden teremben',
                    'Több kisebb tárgyaló egyidejű, egymást nem zavaró használata',
                ],
                'recommended_package' => [
                    'Diszkrét mennyezeti hangszórók a közösségi terekbe',
                    'Asztali/mennyezeti mikrofonrendszer és DSP-processzor a tárgyalókba',
                    'Automatikus visszhang-elnyomás és mikrofon-keverés',
                    'Teams/Zoom-kompatibilis videokonferencia-integráció',
                ],
            ],
            [
                'slug' => 'kereskedelem-uzletek',
                'industry_name' => 'Kereskedelem & Showroomok',
                'meta_title' => 'Hangosítás üzleteknek, plázáknak és showroomoknak',
                'meta_description' => 'Vásárlási élményt támogató háttérzene és ütemezett akció-bemondás üzletekbe, bevásárlóközpontokba és autó-showroomokba, zónánkénti vezérléssel.',
                'order' => 5,
                'description' => "Üzlethelyiségekben, plázákban és autókereskedésekben a hangosítás közvetlenül hat a vásárlási élményre — a megfelelő háttérzene hosszabb tartózkodásra ösztönöz, egy jól időzített akció-bemondás pedig azonnal figyelmet kap.\n\nA rendszert esztétikus, a belsőépítészethez illeszkedő dóm vagy fali hangszórókból építjük fel, ütemezhető lejátszóval, ami előre beállított playlistákat és automatikus akció-bemondásokat is le tud játszani, emberi beavatkozás nélkül is. Nagyobb üzletközpontoknál és showroomoknál a zónánkénti vezérlés lehetővé teszi, hogy az egyes részlegek vagy márkabemutatók külön hangzásvilággal szólaljanak meg.\n\nAz autókereskedések és bemutatótermek esetében külön figyelmet fordítunk arra, hogy a hangosítás ne zavarja a próbaút előtti egyeztetéseket, miközben a bemutatótér hangulata végig prémium marad.",
                'challenges' => [
                    'Vásárlási élményt támogató, de nem tolakodó hangzás',
                    'Ütemezett akció- és promóciós bemondások',
                    'Zónánkénti hangzásvilág részlegenként vagy márkánként',
                    'Esztétikus, a belsőépítészethez illeszkedő hangfalak',
                ],
                'recommended_package' => [
                    'Esztétikus dóm/fali hangszórók',
                    'Ütemezhető bemondó és zenelejátszó egység',
                    'Zónánkénti vezérlés részlegenként',
                    'Streaming/playlist-integráció',
                ],
            ],
            [
                'slug' => 'kozuletek-intezmenyek',
                'industry_name' => 'Oktatás & Közintézmények',
                'meta_title' => 'Hangosítás iskoláknak és közintézményeknek',
                'meta_description' => 'Csengetési rend, aulai rendezvényhangosítás és vészhelyzeti bemondás egyetlen, központilag vezérelt rendszerben iskoláknak és önkormányzatoknak.',
                'order' => 6,
                'description' => "Iskolákban, óvodákban, önkormányzatoknál és más közintézményeknél a hangosítás legfontosabb szempontja a központi vezérlés, a könnyű bővíthetőség és a megbízható, sok végpontra kiterjedő lefedettség.\n\nAz iskolacsengő, az aulai rendezvényhangosítás és a biztonsági bemondórendszer egyetlen, központilag kezelt 100V-os rendszerbe integrálható, amit a portaszolgálat vagy az iskolatitkárság egyetlen gombnyomással, technikai háttértudás nélkül tud kezelni. Az ütemezhető bemondó szoftver automatikusan lejátssza a csengetési rendet, vészhelyzet esetén pedig azonnali, minden zónát elérő bemondásra ad lehetőséget.\n\nA rendszert kifejezetten hosszú távú bővíthetőségre tervezzük: egy új szárny, egy új tanterem vagy egy új épületrész gond nélkül csatlakoztatható a meglévő infrastruktúrához.",
                'challenges' => [
                    'Sok helyiség, egységes központi vezérlés igénye',
                    'Zónánkénti bemondás és riasztás szükségessége',
                    'Hosszú távú bővíthetőség (új szárny, új terem)',
                    'Egyszerű kezelhetőség a portaszolgálat vagy titkárság részéről',
                ],
                'recommended_package' => [
                    '100V rendszer, központi erősítővel',
                    'Zónavezérlő és ütemezhető bemondó szoftver (pl. csengetési rend)',
                    'Központi mikrofonos bemondó pult',
                    'Bővíthető kábelinfrastruktúra új zónákhoz',
                ],
            ],
            [
                'slug' => 'templomok',
                'industry_name' => 'Templomok & Műemlékek',
                'meta_title' => 'Templomi hangosítás — beszédérthetőség és liturgikus bemondás',
                'meta_description' => 'Hosszú utózengésű, kőfalas templomi terekhez optimalizált, beszédre hangolt oszlophangfalak — műemlékvédelmi szempontokat követő, diszkrét kivitelben.',
                'order' => 7,
                'description' => "A templomi és műemléki terek nagy belmagassága, kemény, hangvisszaverő felületei (kő, üveg, csempézett fal) és a hosszú utózengési idő miatt a hangosítás elsődleges célja a beszédérthetőség biztosítása anélkül, hogy a tér akusztikai jellegét vagy a védett belsőépítészeti értékeket megbontanánk.\n\nA hangfalakat keskeny, beszédre optimalizált oszlophangfalak formájában telepítjük, amik pontosan a padsorok vagy a nézőtér irányába sugároznak, elkerülve a felesleges visszaverődést. A mikrofonozást és a digitális visszhangszűrést úgy hangoljuk, hogy a liturgikus szöveg és az orgonahangzás egyaránt tiszta, természetes maradjon.\n\nMűemlék épületeknél a telepítés minden lépését egyeztetjük a műemlékvédelmi szempontokkal — a kábelezés és a hangfalak rögzítése nem járhat a védett felületek sérülésével.",
                'challenges' => [
                    'Nagy belmagasság, hosszú utózengési idő',
                    'Kemény, hangvisszaverő felületek (kő, üveg)',
                    'Egyenetlen lefedettség a padsorok/nézőtér mélyén',
                    'Műemlékvédelmi korlátozások a rögzítésnél és kábelezésnél',
                ],
                'recommended_package' => [
                    'Keskeny, beszédre optimalizált oszlophangfalak',
                    'Zónavezérlő egység (szentély/előtér, hajó, kórus külön hangerővel)',
                    'Mikrofonos bemondó/liturgikus pult, digitális visszhangszűréssel',
                    'Műemlékvédelmi szempontokat követő, diszkrét kábelezés és rögzítés',
                ],
            ],
            [
                'slug' => 'sport-szabadido',
                'industry_name' => 'Sport & Szabadidő',
                'meta_title' => 'Hangosítás sportcsarnokoknak és szabadidőlétesítményeknek',
                'meta_description' => 'Nagy hangerőt és nedves, kültéri környezetet is bíró, IP65 védettségű hangrendszer edzőtermekbe, sportcsarnokokba és szabadtéri pályákra.',
                'order' => 8,
                'description' => "Fitness termekben, sportcsarnokokban, szabadtéri pályákon és uszodákban a hangosításnak két, egymástól nagyon eltérő feltételnek kell megfelelnie: nagy hangerőt és dinamikát kell bírnia a csoportos órák alatt, ugyanakkor a kültéri és nedves környezetben is megbízhatóan kell működnie.\n\nA teremben nagy teljesítményű, dinamikus hangfalakat telepítünk, amik zenés csoportos foglalkozásoknál is tiszta hangzást adnak túlvezérlés nélkül. A szabadtéri pályákon és a medencetérben kifejezetten víz- és páraálló (IP65/IP66 védettségű) hangszórókat és időjárásálló erősítőket használunk, amik nyáron a tűző napot, télen pedig a fagyot is problémamentesen bírják.\n\nNagyobb sportlétesítményeknél a lelátó, az edzőterem és a szabadtéri pálya külön zónában, egymástól függetlenül vezérelhető, hogy egy edzés vagy verseny hangosítása ne zavarja a szomszédos területet.",
                'challenges' => [
                    'Nagy hangerő és dinamika csoportos órákon túlvezérlés nélkül',
                    'Kültéri és nedves (medence) környezet terhelése',
                    'Több zóna (terem, lelátó, szabadtéri pálya) független vezérlése',
                    'Időjárásálló, tartós kültéri telepítés',
                ],
                'recommended_package' => [
                    'Nagy teljesítményű, dinamikus beltéri hangfalak',
                    'Víz- és páraálló (IP65/IP66) Monacor kültéri hangszórók',
                    'Nagy teljesítményű, időjárásálló Castone erősítők',
                    'Zónánkénti, egymástól független vezérlés',
                ],
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::updateOrCreate(['slug' => $solution['slug']], $solution);
        }

        $solutionHeroImages = [
            'templomok' => 'solutions/TkkTZkoYLWSe5EWQWZ8xJQWcdQn7CMG1I4jspBny.webp',
            'fogaszatok-rendelok' => 'solutions/FrBbSYVUssMJyiQsmo3e5CFUy5KshWUOVu1HixUx.webp',
            'kavezok-vendeglatas' => 'solutions/e6sh19Ineojtu0atGbXSR7sxG8iVWVVyS7fCH8DA.webp',
            'kozuletek-intezmenyek' => 'solutions/9TLvnRwzmiHK4C7TMF61GIUtlCZTmZvBfBcbu0Hw.webp',
            'ipar-logisztika' => 'solutions/OSIV6z7hukDUoZ3YdzVy1vLQyvWJhjRbREZbY2B6.webp',
            'kereskedelem-uzletek' => 'solutions/qsCGlPqdZ3k0sOVtvNuN5Ci7NjpUFDGBhWt2sY6r.webp',
            'sport-szabadido' => 'solutions/ZWJGyqV3JJoDuFWDKMHV5QsVwOqa5CbPMRmxHL0z.webp',
        ];

        foreach ($solutionHeroImages as $slug => $heroImage) {
            Solution::where('slug', $slug)->whereNull('hero_image')->update(['hero_image' => $heroImage]);
        }

        $this->call(BlogPostSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(BillableServiceSeeder::class);
        $this->call(QuoteRequestSeeder::class);
        $this->call(EmailFolderSeeder::class);
        $this->call(EmailLabelSeeder::class);
        $this->call(ReplyTemplateSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
