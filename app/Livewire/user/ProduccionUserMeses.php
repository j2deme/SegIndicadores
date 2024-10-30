<?php

namespace App\Livewire\user;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\Registro;
class ProduccionUserMeses extends ChartWidget
{
    protected static ?string $heading = 'Producción Mensual';
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
        $activeFilter=$this->filter;
        $user=auth()->user()->es_admin;
        if($user==1){
            $registros = Registro::select(
                DB::raw('MONTH(registros.created_at) as mes'),
                DB::raw('COUNT(*) as total')
            );
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
            $registros = $registros
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
        }else{
            $registros = Registro::where('user_id', auth()->user()->id)
            ->select(
                DB::raw('MONTH(registros.created_at) as mes'),
                DB::raw('COUNT(*) as total')
            );
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
            $registros = $registros
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
        }

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
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#9966FF', '#FF6384', '#4BC0C0', '#36A2EB', '#FFCE56', '#FF9F40', '#9966FF'],
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta semana',
            'month' => 'Este Mes',
            'year' => 'Este año',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
