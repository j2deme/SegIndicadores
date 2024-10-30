<?php

namespace App\Livewire\user;

use Filament\Widgets\ChartWidget;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;

class ProduccionUserTrimestre extends ChartWidget
{
    protected static ?string $heading = 'Producción Trimestral';
    protected static ?string $maxHeight = '230px';
    public ?string $filter = 'year';

    protected function getData(): array
    {
        $activeFilter=$this->filter;
        $user=auth()->user()->es_admin;
        if($user==1){
            $registros = Registro::select(
            DB::raw('QUARTER(registros.created_at) as trimestre'),
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
                    $now = now();
                    $currentQuarter = $now->quarter;

                    switch ($currentQuarter) {
                        case 1:
                            $start = $now->copy()->startOfYear();
                            $end = $now->copy()->startOfYear()->addMonths(2)->endOfMonth();
                            break;
                        case 2:
                            $start = $now->copy()->startOfYear()->addMonths(3);
                            $end = $now->copy()->startOfYear()->addMonths(5)->endOfMonth();
                            break;
                        case 3:
                            $start = $now->copy()->startOfYear()->addMonths(6);
                            $end = $now->copy()->startOfYear()->addMonths(8)->endOfMonth();
                            break;
                        case 4:
                            $start = $now->copy()->startOfYear()->addMonths(9);
                            $end = $now->copy()->endOfYear();
                            break;
                    }

                    $registros->whereBetween('registros.created_at', [$start, $end]);
                    break;
                case 'year':
                    $registros->whereYear('registros.created_at', now()->year);
                    break;
            }
        $registros=$registros
        ->groupBy('trimestre')
        ->get();
        }else{
            $registros = Registro::where('user_id', auth()->user()->id)
            ->select(
                DB::raw('QUARTER(registros.created_at) as trimestre'),
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
            $registros=$registros
                ->groupBy('trimestre')
                ->get();
        }

        $labels = ['Enero-Marzo', 'Abril-Junio', 'Julio-Septiembre', 'Octubre-Diciembre'];
        $totales = [0, 0, 0, 0];
        foreach ($registros as $registro) {
            $totales[$registro->trimestre - 1] = $registro->total;
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Trimestrales',
                    'borderColor' => 'transparent',
                    'data' => $totales,
                    'label' => [],
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

    protected function getType(): string
    {
        return 'bar';
    }
}
