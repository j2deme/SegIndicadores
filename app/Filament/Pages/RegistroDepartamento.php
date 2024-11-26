<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Pages\Page;
use App\Models\Registro;
use App\Models\Departamento;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class RegistroDepartamento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-document-text';
    protected static string $view = 'filament.pages.registro-departamento';
    protected static ?string $title = 'Registros por Departamento';
    protected static ?string $slug = 'registro-departamento';

    public $filter;
    public $registros;
    public $filtroTexto;
    public $anio;

    public function getHeading(): string
    {
        $departamentoNombre = auth()->user()->departamento->nombre;
        return "Departamento: " . $departamentoNombre;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->es_jefe;
    }

    public static function shouldRegisterNavigation():bool{
        return Departamento::where('jefe_id', auth()->user()->id)->exists();
    }
    public function mount(){
        $this->filter = 'anual';
        $this->anio = Carbon::now()->year;
        $this->registros = $this->getRegistros();
    }
    public function getChartUrl()
    {
        $graficoData = $this->getGrafico();

        $labels = $graficoData->pluck('registrable_type')->map(function ($type) {
            switch ($type) {
                case 'App\Models\Libro':
                    return 'Libro';
                case 'App\Models\Capitulol':
                    return 'Cap. de Libro';
                case 'App\Models\Autoral':
                    return 'Autoral';
                case 'App\Models\Prototipo':
                    return 'Prototipo';
                case 'App\Models\Ponencia':
                    return 'Ponencia';
                case 'App\Models\Industrial':
                    return 'Prop. Intelectual';
                case 'App\Models\Tesis':
                    return 'Tesis';
                case 'App\Models\Otro':
                    return 'Otro';
                case 'App\Models\Capitulom':
                    return 'Cap. de Mem.';
            }
        })->toArray();

        $data = $graficoData->pluck('total')->toArray();

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'boxWidth' => 0,
                    'fontColor' => '#00000',
                    'label' => '',
                    'data' => $data,
                    'backgroundColor' => ['#fc7e99','#65bffc','#f7d379','#75fa6b','#a579fc','#fcad5d','#fc6060','#fc95ab','#aaebfa','#FFCE56']
                ]]
            ],
            'options' => [
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'stepSize' => 1
                        ]
                    ]]
                ],
                'plugins' => [

                    'datalabels' => [
                        'display' => true,
                        'align' => 'center',
                        'anchor' => 'center',
                        'color' => 'black',
                    ],
                ],
                'legend' => [
            'display' => false,
        ],
            ]
        ];

        $chartConfigJson = json_encode($chartConfig);
        $url = "https://quickchart.io/chart?c=" . urlencode($chartConfigJson) . "&width=400&height=300";

        return $url;
    }

    public function getGrafico()
    {
        $depaId = auth()->user()->departamento_id;

        $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', $depaId)
        ->select('registrable_type', DB::raw('count(*) as total'))
        ->groupBy('registrable_type');

        $currentDate = Carbon::now();
        $selectedYear = $this->anio;

        if ($this->filter === 'anual') {
            $query->whereYear('registros.created_at', $selectedYear);
        } elseif ($this->filter === 'trimestre1') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 1, 1), Carbon::createFromDate($selectedYear, 3, 31)]);
        } elseif ($this->filter === 'trimestre2') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 4, 1), Carbon::createFromDate($selectedYear, 6, 30)]);
        } elseif ($this->filter === 'trimestre3') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 7, 1), Carbon::createFromDate($selectedYear, 9, 30)]);
        } elseif ($this->filter === 'trimestre4') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 10, 1), Carbon::createFromDate($selectedYear, 12, 31)]);
        } elseif ($this->filter === 'semestre1') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 1, 1), Carbon::createFromDate($selectedYear, 6, 30)]);
        } elseif ($this->filter === 'semestre2') {
            $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 7, 1), Carbon::createFromDate($selectedYear, 12, 31)]);
        }
        return $query->get();
    }

    public function getRegistros()
{
    $depaId = auth()->user()->departamento_id;
    $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', $depaId)
        ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
        ->orderBy('registros.created_at');

    $currentDate = Carbon::now();
    $selectedYear = $this->anio;

    if ($this->filter === 'anual') {
        $query->whereYear('registros.created_at', $selectedYear);
    } elseif ($this->filter === 'trimestre1') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 1, 1), Carbon::createFromDate($selectedYear, 3, 31)]);
    } elseif ($this->filter === 'trimestre2') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 4, 1), Carbon::createFromDate($selectedYear, 6, 30)]);
    } elseif ($this->filter === 'trimestre3') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 7, 1), Carbon::createFromDate($selectedYear, 9, 30)]);
    } elseif ($this->filter === 'trimestre4') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 10, 1), Carbon::createFromDate($selectedYear, 12, 31)]);
    } elseif ($this->filter === 'semestre1') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 1, 1), Carbon::createFromDate($selectedYear, 6, 30)]);
    } elseif ($this->filter === 'semestre2') {
        $query->whereBetween('registros.created_at', [Carbon::createFromDate($selectedYear, 7, 1), Carbon::createFromDate($selectedYear, 12, 31)]);
    }

    return $query->get();
}


public function generadorPDF()
{
    $registros = $this->getRegistros();
    $chartUrl = $this->getChartUrl();

    $anio = $this->anio;
    $mes = Carbon::now()->month;

    switch($this->filter){
        case 'anual':
            $filtroTexto = 'Enero - Diciembre ' . $anio;
            break;
        case 'trimestre1':
            $filtroTexto = 'Trimestre Enero - Marzo ' . $anio;
            break;
        case 'trimestre2':
            $filtroTexto = 'Trimestre Abril - Junio ' . $anio;
            break;
        case 'trimestre3':
            $filtroTexto = 'Trimestre Julio - Septiembre ' . $anio;
            break;
        case 'trimestre4':
            $filtroTexto = 'Trimestre Octubre - Diciembre ' . $anio;
            break;
        case 'semestre1':
            $filtroTexto = 'Semestre Enero - Junio ' . $anio;
            break;
        case 'semestre2':
            $filtroTexto = 'Semestre Julio - Diciembre ' . $anio;
            break;
    }

    $html = view('reports.reportes-registros', [
        'registros' => $registros,
        'filtroTexto' => $filtroTexto,
        'chartUrl' => $chartUrl
    ])->render();

    Browsershot::html($html)
        ->setOption('no-sandbox', true)
        ->setOption('landscape', true)
        ->setDelay(5000)
        ->waitFor('#chart')
        ->save(storage_path('app/public/reports/reporte_de_area.pdf'));

    return response()->download(storage_path('app/public/reports/reporte_de_area.pdf'))
        ->deleteFileAfterSend(true);
}


}
