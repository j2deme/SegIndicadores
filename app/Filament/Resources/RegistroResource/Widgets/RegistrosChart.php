<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Registro;

class RegistrosChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Producción';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $user= auth()->user()->es_admin;
        if($user==1){
            $query = Registro::selectRaw('count(*) as total, registrable_type')
            ->groupBy('registrable_type')
            ->get();
        }else{
            $query = Registro::where('user_id', auth()->user()->id)
            ->groupBy('registrable_type')
            ->selectRaw('count(*) as total, registrable_type')
            ->get();
        }
        //dd($query);

        return [
            'labels' => $this->tipoLabel($query->pluck('registrable_type')),
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
