<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use App\Models\Departamento;
use App\Models\Registro;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
class ProduccionDepartamento extends ChartWidget
{
    protected static ?string $heading = 'Producción departamental';
    protected static ?string $maxHeight = '220px';

    protected function getData(): array
    {
        $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', auth()->user()->departamento_id)
        ->groupBy('registrable_type')
        ->selectRaw('count(*) as total, registrable_type')
        ->get();

            return [
                'labels' => $this->tipoLabel($query->pluck('registrable_type')),
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

    private function tipoLabel($tipos): array
    {
        $labels = [];
        foreach ($tipos as $tipo) {
            if (str($tipo)->endsWith('Capitulom')) {
                $label = 'Capítulo de Memoria';
            } elseif (str($tipo)->endsWith('Capitulol')) {
                $label = 'Capítulo de Libro';
            } else {
                $label = str_replace('App\\Models\\', '', $tipo);
            }
            array_push($labels, $label);
        }
        return $labels;
    }
}
