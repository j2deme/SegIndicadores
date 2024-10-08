<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\Registro;

class EstadisticaChart extends ChartWidget
{
    protected static ?string $heading = 'Producción Mensual del Departamento';
    protected static ?string $maxHeight = '230px';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];
        protected function getData(): array
        {
            /*$jefeId = auth()->user()->id;
            $departamento = Departamento::where('jefe_id', $jefeId)->first();
            $depaId = $departamento->id;

*/
            $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->select(
                DB::raw('MONTH(registros.created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

            $labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $totales = array_fill(0,12, 0);
            foreach ($registros as $registro) {
                $totales[$registro->mes - 1] = $registro->total;
            }
            return [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Mensual',
                        'data' => $totales,
                        'backgroundColor' => ['#FFFFFF', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#9966FF', '#FF6384', '#4BC0C0', '#36A2EB', '#FFCE56', '#FF9F40', '#9966FF'],
                    ],
                ],
            ];
        }

        protected function getType(): string
        {
            return 'line';
        }
}
