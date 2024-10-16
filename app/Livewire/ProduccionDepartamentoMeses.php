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
    protected static ?string $heading = null;
    protected static ?string $maxHeight = '230px';
    public ?string $filter = 'today';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        #$jefeId = auth()->user()->id;
        #$departamento = Departamento::where('jefe_id', $jefeId)->first();

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
        $registros= $registros->select(
            DB::raw('QUARTER(registros.created_at) as trimestre'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('trimestre')
        ->get();

        $labels = ['Enero-Marzo', 'Abril-Junio', 'Julio-Septiembre', 'Octubre-Diciembre'];
        $totales = [0, 0, 0, 0];
        foreach ($registros as $registro) {
            $totales[$registro->trimestre - 1] = $registro->total;
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                   'label' => [],
                    'data' => $totales,
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta semana',
            'month' => 'Este trimestre',
            'year' => 'Este año',
        ];
    }
    public function getHeading(): ?string{
        $user = auth()->user()->es_admin;

        if($user==1){
            return 'Producción global por trimestre';
        }else{
            $departamento=auth()->user()->departamento_id;
            $departamento=Departamento::find($departamento);
            return 'Producción departamental por trimestre de '.$departamento->nombre;
        }
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
