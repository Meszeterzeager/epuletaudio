<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuoteRequestStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = QuoteRequest::count();

        return [
            Stat::make('Összes ajánlatkérés', (string) $total),
            Stat::make('Új', (string) QuoteRequest::where('status', 'new')->count())
                ->color('danger'),
            Stat::make('Ajánlat kiadva', (string) QuoteRequest::where('status', 'quote_issued')->count())
                ->color('info'),
            Stat::make('Ajánlat lerendelve', (string) QuoteRequest::where('status', 'ordered')->count())
                ->color('success'),
            Stat::make('Ajánlat elhalasztva', (string) QuoteRequest::where('status', 'postponed')->count())
                ->color('warning'),
        ];
    }
}
