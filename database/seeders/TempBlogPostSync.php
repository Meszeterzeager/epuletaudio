<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

/**
 * One-off sync of the rewritten "akusztikai-felmeres" blog post. Delete after running.
 */
class TempBlogPostSync extends Seeder
{
    public function run(): void
    {
        BlogPost::where('slug', 'akusztikai-felmeres-hangositas-elott')->update([
            'title' => 'Pontos hangosítási terv fotók és videók alapján — mikor van mégis szükség helyszíni felmérésre?',
            'excerpt' => 'A projektek nagy részét fotók, videók és alaprajz alapján, helyszíni kiszállás nélkül is pontosan meg tudjuk tervezni. Megmutatjuk, mit érdemes elküldeni, és mikor van mégis szükség személyes felmérésre.',
            'meta_title' => 'Hangosítás tervezése fotó és videó alapján — helyszíni felmérés nélkül',
            'meta_description' => 'A legtöbb hangosítási projekt pontosan megtervezhető fotók, videók és alaprajz alapján, helyszíni felmérés nélkül. Megmutatjuk, mit küldj el, és mikor van mégis szükség kiszállásra.',
            'body' => <<<'HTML'
                <p>Egy hangosítási projekt sikere nem a hangfalak márkáján vagy a wattszámon dől el elsősorban, hanem azon, hogy a rendszert a helyiség adottságaihoz igazítva tervezték-e meg. Sokan azt gondolják, hogy ehhez elengedhetetlen egy személyes helyszíni bejárás — a tapasztalatunk szerint viszont a projektek nagy százalékában jó minőségű fotók, egy rövid videós bejárás és (ha van) egy alaprajz alapján ugyanolyan pontosan meg tudjuk tervezni a rendszert, mintha ott álltunk volna a teremben.</p>

                <h2>Mit tudunk megállapítani fotók és videók alapján</h2>
                <ul>
                    <li><strong>Felületek anyaga:</strong> a kemény, sík felületek (üveg, kő, csempézett fal) visszaverik, a puha, szabálytalan felületek (szövet, szőnyeg, bútor) elnyelik a hangot — ez jól látszik jó megvilágítású fotókon.</li>
                    <li><strong>Helyiség geometriája és mérete:</strong> alaprajz vagy a szélesség/hosszúság/belmagasság megadása alapján pontosan kiszámítható a szükséges hangfalak száma és elhelyezése, akár párhuzamos falak vagy íves mennyezet esetén is.</li>
                    <li><strong>Mennyezet típusa:</strong> egy fotóból vagy néhány mondatos leírásból (pl. van-e álmennyezet, és ha igen, milyen — gipszkarton, kazettás, fém lamella) eldönthető, hogy a hangfalak süllyeszthetők-e, vagy más rögzítési módra lesz szükség.</li>
                    <li><strong>A tér tényleges használata:</strong> az ajánlatkérő űrlapon megadott célok (bemondás, háttérzene, konferencia stb.) és a várható forgalom alapján méretezzük a rendszert az üresen és a zsúfoltan várható hangzásra egyaránt.</li>
                    <li><strong>Meglévő rendszer állapota:</strong> ha van már hangosítás a helyszínen, fotók és egy rövid leírás alapján felmérjük, mi működik, és mit érdemes lecserélni vagy kiegészíteni.</li>
                </ul>
                <p>Amit fotóból nehezebb megbecsülni — elsősorban a pontos utózengési időt (RT60) és a háttérzaj tényleges szintjét —, azt tapasztalati értékekkel és a hasonló, korábban megtervezett terek adataival pótoljuk, ezért kérünk minél pontosabb leírást a helyiség jellegéről és rendeltetéséről.</p>

                <h2>Mit érdemes elküldened az ajánlatkéréshez</h2>
                <p>Néhány egyszerű dolog nagyban javítja az ajánlat pontosságát: készíts fotókat minden sarokból, lehetőleg úgy, hogy a mennyezet és a padló is látszódjon; vegyél fel egy rövid, lassan körbepásztázó videót a teremről; ha van alaprajz vagy korábbi tervrajz, csatold azt is; és add meg a szélességet, hosszúságot, belmagasságot és az alapterületet, amennyire pontosan csak tudod. Mindezt egyszerűen megteheted a <a href="/ajanlatkeres">ajánlatkérő űrlapunkon</a>, ahol lépésről lépésre kérdezünk rá minden fontos szempontra.</p>

                <h2>Hogyan készül el a terv ezek alapján</h2>
                <p>A beküldött anyagok alapján meghatározzuk a szükséges hangfalak számát, típusát és elhelyezését, kiszámoljuk a hangnyomás-eloszlást, és javaslatot teszünk a zónázásra. Ha bármi bizonytalan marad — például egy szokatlan geometriájú tér vagy egy különösen zajos környezet esetén —, inkább rákérdezünk egy-két kiegészítő fotóval vagy egy rövid telefonos egyeztetéssel, mintsem hogy találgatnánk.</p>

                <h2>Mikor van mégis szükség helyszíni felmérésre</h2>
                <p>Vannak esetek, amikor egy személyes bejárás valóban többet ér, mint bármennyi fotó: nagy kiterjedésű, összetett ipari csarnokoknál és raktáraknál, ahol a nagy távolságok és a mostoha környezeti körülmények (por, zaj, magas belmagasság) miatt helyszíni hangnyomás-mérésre van szükség; műemlék épületeknél, ahol a rögzítési pontokat a műemlékvédelmi szempontokkal együtt kell egyeztetni; vagy amikor egy meglévő rendszer valamilyen nehezen leírható akusztikai problémáját kell személyesen diagnosztizálni. Ezekben az esetekben (igény esetén díjköteles) helyszíni felmérést vagy konzultációt javaslunk — de ez a kisebbség, nem az alapértelmezett lépés.</p>

                <p>Ha bizonytalan vagy, hogy a te tered melyik kategóriába esik, <a href="/ajanlatkeres">kérj ajánlatot</a> — küldd el a fotókat, videókat és az alaprajzot, mi pedig megmondjuk, hogy ez alapján tudunk-e pontos ajánlatot adni, vagy inkább javaslunk egy személyes egyeztetést.</p>
                HTML,
        ]);
    }
}
