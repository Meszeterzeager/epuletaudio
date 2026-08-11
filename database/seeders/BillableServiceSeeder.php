<?php

namespace Database\Seeders;

use App\Models\BillableService;
use Illuminate\Database\Seeder;

class BillableServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Hangrendszer telepítés', 'unit' => 'alkalom', 'default_price' => null],
            ['name' => 'Szerelési anyag', 'unit' => 'tétel', 'default_price' => null],
            ['name' => 'Kellék', 'unit' => 'tétel', 'default_price' => null],
            ['name' => 'Hangszórókábel', 'unit' => 'm', 'default_price' => null],
            ['name' => 'Kiszállási díj', 'unit' => 'alkalom', 'default_price' => null],
            ['name' => 'Beüzemelés', 'unit' => 'alkalom', 'default_price' => null],
        ];

        foreach ($items as $item) {
            BillableService::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
