<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuoteRequestStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $counts = QuoteRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = $counts->sum();

        return [
            Stat::make('Összes ajánlatkérés', (string) $total),
            Stat::make('Új', (string) ($counts['new'] ?? 0))
                ->color('danger'),
            Stat::make('Ajánlat kiadva', (string) ($counts['quote_issued'] ?? 0))
                ->color('info'),
            Stat::make('Ajánlat lerendelve', (string) ($counts['ordered'] ?? 0))
                ->color('success'),
            Stat::make('Ajánlat elhalasztva', (string) ($counts['postponed'] ?? 0))
                ->color('warning'),
        ];
    }
}
