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
    protected static ?string $heading = null;
    protected static ?string $maxHeight = '200px';
    protected static ?string $height = '250px';
    public ?string $filter = 'year';

    public function getHeading():string
{
    $user=auth()->user()->es_admin;
    $departamentoId = auth()->user()->departamento_id;

    $departamento = Departamento::find($departamentoId);

    if ($user==1) {
        return 'Producción por Docente';
    } else {
        return 'Producción departamental por docente de '. $departamento->nombre;
    }
}

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $user=auth()->user()->es_admin;
        if($user==1){
            $topCinco = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->select(
                DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                DB::raw('COUNT(*) as total'),
                'users.id'
            );
            switch ($activeFilter) {
                case 'today':
                    $topCinco->whereDate('registros.created_at', today());
                    break;
                case 'week':
                    $topCinco->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $topCinco->whereMonth('registros.created_at', now()->month)
                        ->whereYear('registros.created_at', now()->year);
                    break;
                case 'year':
                    $topCinco->whereYear('registros.created_at', now()->year);
                    break;
            }
            $topCinco=$topCinco
            ->groupBy('users.id', 'users.name', 'users.apellidos')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();


            $otros = Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->whereNotIn('users.id', $topCinco->pluck('id'));
                switch ($activeFilter) {
                    case 'today':
                        $otros->whereDate('registros.created_at', today());
                        break;
                    case 'week':
                        $otros->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $otros->whereMonth('registros.created_at', now()->month)
                            ->whereYear('registros.created_at', now()->year);
                        break;
                    case 'year':
                        $otros->whereYear('registros.created_at', now()->year);
                        break;
                }
                $otros=$otros
                ->count();

            $labels = $topCinco->pluck('usuario')->toArray();
            $data = $topCinco->pluck('total')->toArray();

            if ($otros > 0) {
                $labels[] = 'Otros';
                $data[] = $otros;
            }
            /*$query = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->select(
                DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                DB::raw('COUNT(*) as total')
            );
            switch ($activeFilter) {
                case 'today':
                    $query->whereDate('registros.created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('registros.created_at', now()->month)
                        ->whereYear('registros.created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('registros.created_at', now()->year);
                    break;
            }
            $query= $query
            ->groupBy('users.id', 'users.name', 'users.apellidos')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();*/
        }else{
            $topCinco = Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->select(
                    DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                    DB::raw('COUNT(*) as total'),
                    'users.id'
                );
                switch ($activeFilter) {
                    case 'today':
                        $topCinco->whereDate('registros.created_at', today());
                        break;
                    case 'week':
                        $topCinco->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $topCinco->whereMonth('registros.created_at', now()->month)
                            ->whereYear('registros.created_at', now()->year);
                        break;
                    case 'year':
                        $topCinco->whereYear('registros.created_at', now()->year);
                        break;
                }
                $topCinco=$topCinco
                ->groupBy('users.id', 'users.name', 'users.apellidos')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();





            /*$query = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id);

            switch ($activeFilter) {
                case 'today':
                    $query->whereDate('registros.created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('registros.created_at', now()->month)
                        ->whereYear('registros.created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('registros.created_at', now()->year);
                    break;
            }

            $query= $query->select(
                DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('usuario')
            ->orderBy('usuario')
            ->get();*/
        }
        $otros = Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->whereNotIn('users.id', $topCinco->pluck('id'));
                switch ($activeFilter) {
                    case 'today':
                        $otros->whereDate('registros.created_at', today());
                        break;
                    case 'week':
                        $otros->whereBetween('registros.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $otros->whereMonth('registros.created_at', now()->month)
                            ->whereYear('registros.created_at', now()->year);
                        break;
                    case 'year':
                        $otros->whereYear('registros.created_at', now()->year);
                        break;
                }
                $otros=$otros
                ->count();

            $labels = $topCinco->pluck('usuario')->toArray();
            $data = $topCinco->pluck('total')->toArray();

            if ($otros > 0) {
                $labels[] = 'Otros';
                $data[] = $otros;
            }

            return [
                'labels' => $labels,
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
                        'data' => $data,
                    ],
                ],
            ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta Semana',
            'month' => 'Este Mes',
            'year' => 'Este año',
        ];
    }

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
        'tooltips' => [
            'enabled' => false,
        ],
        'scales' => [
            'y' => [
                'beginAtZero' => false,
                'display' => false,
            ],
            'x' => [
                'display' => false,
            ],
        ],
    ];

    /*public function getDescription(): ?string
    {
        return 'Total de registros del departamento por docentes.';
    }*/


    protected function getType(): string
    {
        return 'pie';
    }
}
