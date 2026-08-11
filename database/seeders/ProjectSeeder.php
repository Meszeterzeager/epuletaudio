<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Solution;
use App\Services\ImageOptimizer;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Demó/placeholder referenciák — a valódi projektadatok és fotók
     * beérkezéséig szemléltetik a referencia-oldalak elrendezését.
     */
    public function run(): void
    {
        // Csak 1 db minta marad, amíg valódi referenciafotó és leírás nem
        // érkezik — a Referenciák menüpont is kikapcsolt állapotban van
        // alapból (ld. SiteSettingsSeeder / Setting::get('references_enabled')).
        $projects = [
            [
                'solution_slug' => 'templomok',
                'slug' => 'minta-referencia-templom',
                'title' => 'Minta referencia — templomi hangosítás',
                'location' => 'Demó helyszín',
                'label' => 'DEMO - TEMPLOM',
                'completed_at' => now()->subMonths(7),
                'description' => 'Ez egy demonstrációs referencia, amíg a valódi projektfotók és leírás feltöltésre kerülnek. Egy tipikus templomi épülethangosítási projekt jellemzően zónánként vezérelt hangfalakból, mikrofonos bemondó egységből, és a hosszú utózengési időhöz igazított beszédérthetőségi tervezésből áll.',
            ],
        ];

        foreach ($projects as $data) {
            $solution = Solution::where('slug', $data['solution_slug'])->first();

            $project = Project::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'solution_id' => $solution?->id,
                    'description' => $data['description'],
                    'location' => $data['location'],
                    'completed_at' => $data['completed_at'],
                ]
            );

            Storage::disk('public')->delete($project->images()->pluck('path')->all());
            $project->images()->delete();

            foreach ([1, 2] as $order) {
                $path = $this->generatePlaceholderImage($data['label'], $order);

                $project->images()->create([
                    'path' => $path,
                    'alt' => 'Demó/placeholder kép — a valódi projektfotó feltöltése folyamatban',
                    'order' => $order,
                ]);
            }
        }
    }

    /**
     * Egyszerű, egyértelműen "DEMO" feliratú gradiens kép generálása
     * GD-vel — nem valódi projektfotó, csak elrendezés-minta.
     */
    private function generatePlaceholderImage(string $label, int $variant): string
    {
        $width = 1200;
        $height = 800;

        $image = imagecreatetruecolor($width, $height);

        $topColor = $variant === 1 ? [15, 61, 62] : [10, 42, 43];
        $bottomColor = [31, 102, 104];

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int) ($topColor[0] + ($bottomColor[0] - $topColor[0]) * $ratio);
            $g = (int) ($topColor[1] + ($bottomColor[1] - $topColor[1]) * $ratio);
            $b = (int) ($topColor[2] + ($bottomColor[2] - $topColor[2]) * $ratio);
            $lineColor = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $lineColor);
        }

        $gold = imagecolorallocate($image, 217, 165, 87);
        $petrolDark = imagecolorallocate($image, 10, 42, 43);
        $cream = imagecolorallocate($image, 250, 247, 242);

        imagefilledellipse($image, (int) ($width / 2), (int) ($height / 2) - 30, 220, 220, $gold);
        imagefilledellipse($image, (int) ($width / 2), (int) ($height / 2) - 30, 160, 160, $petrolDark);

        $labelBadge = 'DEMO';
        imagestring($image, 5, (int) ($width / 2 - (strlen($labelBadge) * 5)), (int) ($height / 2) - 40, $labelBadge, $cream);

        imagestring($image, 4, (int) ($width / 2 - (strlen($label) * 4)), (int) ($height / 2) + 130, $label, $cream);
        imagestring($image, 2, (int) ($width / 2 - 130), (int) ($height / 2) + 155, 'Placeholder - valodi foto hamarosan', $cream);

        $tmpPath = tempnam(sys_get_temp_dir(), 'placeholder').'.jpg';
        imagejpeg($image, $tmpPath, 90);
        imagedestroy($image);

        $uploaded = new UploadedFile($tmpPath, 'placeholder.jpg', 'image/jpeg', null, true);
        $path = ImageOptimizer::store($uploaded, 'projects', 'public', 1200, 800);

        @unlink($tmpPath);

        return $path;
    }
}
