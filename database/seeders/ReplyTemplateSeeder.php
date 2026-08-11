<?php

namespace Database\Seeders;

use App\Models\ReplyTemplate;
use Illuminate\Database\Seeder;

class ReplyTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Ajánlat elküldve',
                'body' => "Tisztelt Ügyfelünk!\n\nMellékelten megküldjük az elkészült árajánlatot. Kérdés esetén állunk rendelkezésére.",
            ],
            [
                'name' => 'Garancia tájékoztató',
                'body' => "Tisztelt Ügyfelünk!\n\nA vásárolt termékre 2 év garanciát vállalunk. Meghibásodás esetén kérjük, csatolja a vásárlást igazoló számlát.",
            ],
            [
                'name' => 'Szállítási visszaigazolás',
                'body' => "Tisztelt Ügyfelünk!\n\nRendelését visszaigazoltuk, a kiszállítás várható időpontjáról hamarosan tájékoztatjuk.",
            ],
        ];

        foreach ($templates as $template) {
            ReplyTemplate::firstOrCreate(['name' => $template['name']], $template);
        }
    }
}
