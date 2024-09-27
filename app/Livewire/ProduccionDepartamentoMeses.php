<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Registro;
use Carbon\Carbon;

class ProduccionDepartamentoMeses extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Trend::model(Registro::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Registros',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'backgroundColor' => [
                        '#3b82f6',
                        '#ef4444',
                        '#22c55e',
                        '#f59e0b',
                        '#ec4899',
                        '#10b981',
                        '#6366f1',
                        '#84cc16',
                        '#14b8a6',
                        '#f97316',
                        '#0ea5e9',
                        '#f87171',
                        '#4ade80',
                        '#facc15',
                        '#f472b6',
                        '#6ee7b7',
                        '#818cf8',
                        '#a3e635',
                        '#2dd4bf',
                        '#fb923c',
                    ],
            ],
        ],
        'labels' => $data->map(function (TrendValue $value){
            $date = Carbon::createFromFormat('Y-m', $value->date);
            $formatedDate = $date->format('M');

            return $formatedDate;

        }),
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
