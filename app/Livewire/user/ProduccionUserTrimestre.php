<?php

namespace App\Livewire\user;

use Filament\Widgets\ChartWidget;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;

class ProduccionUserTrimestre extends ChartWidget
{
    protected static ?string $heading = 'Producción Trimestral';
    protected static ?string $maxHeight = '230px';

    protected function getData(): array
    {
        $user=auth()->user()->es_admin;
        if($user==1){
            $registros = Registro::select(
            DB::raw('QUARTER(registros.created_at) as trimestre'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('trimestre')
        ->get();
        }else{
            $registros = Registro::where('user_id', auth()->user()->id)
        ->select(
            DB::raw('QUARTER(registros.created_at) as trimestre'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('trimestre')
        ->get();
        }

        $labels = ['Enero-Marzo', 'Abril-Junio', 'Julio-Septiembre', 'Octubre-Diciembre'];
        $totales = [0, 0, 0, 0];
        foreach ($registros as $registro) {
            $totales[$registro->trimestre - 1] = $registro->total;
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Trimestrales',
                    'borderColor' => 'transparent',
                    'data' => $totales,
                    'label' => [],
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
        ];
    }
    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getType(): string
    {
        return 'bar';
    }
}
