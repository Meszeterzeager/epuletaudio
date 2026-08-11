<?php

namespace Database\Seeders;

use App\Models\EmailLabel;
use Illuminate\Database\Seeder;

class EmailLabelSeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            ['name' => 'Ajánlat', 'color' => 'blue'],
            ['name' => 'Rendelés', 'color' => 'rose'],
        ];

        foreach ($labels as $label) {
            EmailLabel::firstOrCreate(['name' => $label['name']], $label);
        }
    }
}
