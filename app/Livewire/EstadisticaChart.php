<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\Registro;

class EstadisticaChart extends ChartWidget
{
    protected static ?string $heading = null;
    protected static ?string $maxHeight = '230px';
    public ?string $filter = 'year';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'beginAtZero' => true,
                    'stepSize' => 1,
                    ],
            ],
        ],
    ];
        protected function getData(): array
        {
            $activeFilter = $this->filter;
            /*$jefeId = auth()->user()->id;
            $departamento = Departamento::where('jefe_id', $jefeId)->first();
            $depaId = $departamento->id;

*/
            $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id);
            switch ($activeFilter) {
                case 'today':
                    $registros->whereDate('registros.created_at', today());
                    break;
                case 'week':
                    $registros->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $registros->whereMonth('registros.created_at', now()->month)
                        ->whereYear('registros.created_at', now()->year);
                    break;
                case 'year':
                    $registros->whereYear('registros.created_at', now()->year);
                    break;
            }
            $registros=$registros->select(
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

        protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta semana',
            'month' => 'Este mes',
            'year' => 'Este año',
        ];
    }

    public function getHeading(): ?string{
        $user = auth()->user()->es_admin;
        if($user==1){
            return 'Producción mensual global';
        }else{
            $departamentoId = auth()->user()->departamento_id;
            $departamento = Departamento::where('id', $departamentoId)->first();
            return 'Producción mensual del departamento de '. $departamento->nombre;
        }
    }

        protected function getType(): string
        {
            return 'line';
        }
}
