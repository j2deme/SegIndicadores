<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Registro;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class RegistrosGeneralesDepartamentosChart extends ChartWidget
{
    protected static ?string $heading = 'Producción Departamental';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $user=auth()->user()->es_admin;
        $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->join('departamentos', 'users.departamento_id', '=', 'departamentos.id')
        ->selectRaw('count(*) as total, departamentos.nombre as departamento')
        ->groupBy('departamentos.nombre')
        ->get();

        if($user==1){
            return [
                'labels' => $query->pluck('departamento'),
                'datasets' => [
                    [
                        'label' => 'Registros',
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
                        'data' => $query->pluck('total'),
                    ],
                ],
            ];
        }else{
            return[];
        }
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
