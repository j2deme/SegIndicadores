<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Registro;
use App\Models\Departamento;
use Carbon\Carbon;

class ProduccionDepartamentoMeses extends ChartWidget
{
    protected static ?string $heading = 'Producción Departamental por Trimestre';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {

        #$jefeId = auth()->user()->id;
        #$departamento = Departamento::where('jefe_id', $jefeId)->first();

        $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', auth()->user()->departamento_id)
        ->select(
            DB::raw('QUARTER(registros.created_at) as trimestre'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('trimestre')
        ->get();

        $labels = ['Enero-Marzo', 'Abril-Junio', 'julio-Septiembre', 'Octubre-Diciembre'];
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
