<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\Solution;
use App\Services\ImageOptimizer;
use Illuminate\Console\Command;

class BackfillImageThumbs extends Command
{
    protected $signature = 'images:backfill-thumbs';

    protected $description = 'Generate the missing "_thumb" card variant for existing solution/service hero images';

    public function handle(): int
    {
        foreach ([Solution::class, Service::class] as $model) {
            $model::query()->whereNotNull('hero_image')->each(function ($record) {
                ImageOptimizer::backfillThumb($record->hero_image);
                $this->line("Backfilled thumb for {$record->hero_image}");
            });
        }

        $this->info('Done.');

        return self::SUCCESS;
    }
}
