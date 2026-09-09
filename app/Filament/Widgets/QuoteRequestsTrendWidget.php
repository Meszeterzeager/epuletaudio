<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class QuoteRequestsTrendWidget extends ChartWidget
{
    protected ?string $heading = 'Beérkezett ajánlatkérések (utolsó 8 hét)';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $weeks = collect(range(7, 0))->map(fn (int $weeksAgo) => now()->subWeeks($weeksAgo)->startOfWeek());

        $firstWeek = $weeks->first();
        $lastWeek = $weeks->last()->copy()->endOfWeek();
        $driver = DB::connection()->getDriverName();
        $weekExpression = match ($driver) {
            'mysql', 'mariadb' => 'YEARWEEK(created_at, 3)',
            'pgsql' => "TO_CHAR(created_at, 'IYYY-IW')",
            default => "strftime('%Y-%W', created_at)",
        };

        $countsByWeek = QuoteRequest::query()
            ->whereBetween('created_at', [$firstWeek, $lastWeek])
            ->selectRaw("{$weekExpression} as week, COUNT(*) as total")
            ->groupBy('week')
            ->pluck('total', 'week');

        $weekKey = fn ($weekStart): string => match ($driver) {
            'mysql', 'mariadb' => $weekStart->format('oW'),
            'pgsql' => $weekStart->format('o-W'),
            default => $weekStart->format('Y-W'),
        };

        $counts = $weeks->map(fn ($weekStart) => $countsByWeek[$weekKey($weekStart)] ?? 0);

        return [
            'datasets' => [
                [
                    'label' => 'Ajánlatkérések',
                    'data' => $counts->values(),
                    'backgroundColor' => '#c9793a',
                ],
            ],
            'labels' => $weeks->map(fn ($weekStart) => $weekStart->format('m.d'))->values(),
        ];
    }
}
