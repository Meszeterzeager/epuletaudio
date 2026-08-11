<?php

namespace Database\Seeders;

use App\Models\EmailFolder;
use Illuminate\Database\Seeder;

class EmailFolderSeeder extends Seeder
{
    public function run(): void
    {
        $folders = [
            ['key' => 'inbox', 'name' => 'Beérkező', 'type' => 'system', 'order' => 1],
            ['key' => 'sent', 'name' => 'Elküldött', 'type' => 'system', 'order' => 2],
            ['key' => 'drafts', 'name' => 'Piszkozatok', 'type' => 'system', 'order' => 3],
            ['key' => 'trash', 'name' => 'Törölt', 'type' => 'system', 'order' => 4],
        ];

        foreach ($folders as $folder) {
            EmailFolder::updateOrCreate(['key' => $folder['key']], $folder);
        }
    }
}
