<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Csak akkor töltjük be az alapértelmezett aláírást, ha még nincs
        // beállítva — így egy admin által már szerkesztett aláírást nem ír
        // felül egy esetleges újra-seedelés. A RichEditor "üres" állapota
        // "<p></p>" string, ezt is üresnek tekintjük.
        $current = trim((string) Setting::get('email_signature', ''));

        if (blank($current) || $current === '<p></p>') {
            $logo = asset('images/logo-icon.png');

            Setting::set('email_signature', <<<HTML
                <p style="margin:0 0 10px;"><img src="{$logo}" alt="Épületaudio" style="height:36px;width:auto;display:block;"></p>
                <p style="margin:0;font-size:15px;"><strong style="color:#002828;">Pálvölgyi Tamás</strong><br><span style="color:#6b7280;">Épületaudio</span></p>
                <p style="margin:10px 0 0;padding-top:10px;border-top:2px solid #c9793a;font-size:13px;"><a href="mailto:info@epuletaudio.hu" style="color:#005050;text-decoration:none;">info@epuletaudio.hu</a> &middot; <a href="tel:+36201234567" style="color:#005050;text-decoration:none;">06 20 1234 567</a><br><a href="https://epuletaudio.hu" style="color:#c9793a;text-decoration:none;font-weight:600;">epuletaudio.hu</a></p>
                HTML);
        }
    }
}
