<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Registro;
use Carbon\Carbon;

class RegistrosMes2 extends ChartWidget
{
    protected static ?string $heading = 'Chart';

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
