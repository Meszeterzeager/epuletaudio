<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use Filament\Widgets\ChartWidget;

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

        $counts = $weeks->map(
            fn ($weekStart) => QuoteRequest::whereBetween('created_at', [$weekStart, $weekStart->copy()->endOfWeek()])->count()
        );

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
