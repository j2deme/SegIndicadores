<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

use Illuminate\Support\Facades\DB;
use App\Models\Registro;
use App\Models\Departamento;


class TrimisteChart extends ChartWidget
{
    protected static ?string $heading = 'Registros';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getData(): array
    {
        $jefeId = auth()->user()->id;
        $departamento = Departamento::where('jefe_id', $jefeId)->first();
        $depaId = $departamento->id;


        $registros = Registro::where('sector_id', $depaId)
        ->select(
            DB::raw('QUARTER(created_at) as trimestre'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('trimestre')
        ->get();


        $labels = ['Enero-Marzo', 'Abril-Junio', 'julio-Septiembre', 'Octubre-Noviembre'];
        $totales = [0, 0, 0, 0];
        foreach ($registros as $registro) {
            $totales[$registro->trimestre - 1] = $registro->total;
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Trimestales',
                    'data' => $totales,
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
