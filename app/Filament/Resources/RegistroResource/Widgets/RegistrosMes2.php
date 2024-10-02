<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Registro;
use Carbon\Carbon;

class RegistrosMes2 extends ChartWidget
{
    protected static ?string $heading = 'Producción Trimestral';

    protected function getData(): array
    {
        $user=auth()->user()->es_admin;
        if($user==1){
            $registros = Registro::select(
                DB::raw('QUARTER(created_at) as trimestre'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('trimestre')
            ->get();
        }else{
            $registros = Registro::where('user_id', auth()->user()->id)
            ->select(
                DB::raw('QUARTER(created_at) as trimestre'),
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
                    'label' => 'Trimestre',
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
