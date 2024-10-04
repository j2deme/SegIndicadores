<?php
namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Registro;
use App\Models\Departamento;
use Carbon\Carbon;

class ProduccionDepartamentoDocentes extends ChartWidget
{
    protected static ?string $heading = 'Producción Departamental por Docente';
    protected static ?string $maxHeight = '200px';
    protected static ?string $height = '250px';

    protected function getData(): array
    {
        $user=auth()->user()->es_admin;
        if($user==1){
            $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->select(
                DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('users.id', 'users.name', 'users.apellidos')
            ->orderBy('usuario')
            ->get();
        }else{
            $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->select(
                DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('usuario')
            ->orderBy('usuario')
            ->get();
        }

        return [

            'labels' => $query->pluck('usuario'),
                'datasets' => [
                    [
                        'label' => 'Producción por departamento de:',
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
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
