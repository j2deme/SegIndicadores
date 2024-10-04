<?php

namespace App\Livewire\user;

use Filament\Widgets\ChartWidget;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;

class ProduccionUserGeneral extends ChartWidget
{
    protected static ?string $heading = 'Producción General';
    protected static ?string $maxHeight = '230px';
    protected function getData(): array
    {
        $user=auth()->user()->es_admin;
        if($user==1){
            $query = Registro::groupBy('registrable_type')
            ->selectRaw('count(*) as total, registrable_type')
            ->get();
        }else{
            $query = Registro::where('user_id', auth()->user()->id)
            ->groupBy('registrable_type')
            ->selectRaw('count(*) as total, registrable_type')
            ->get();
        }
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
