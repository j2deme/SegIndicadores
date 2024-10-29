<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Registro;
use App\Models\Departamento;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class RegistroDepartamento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.registro-departamento';
    protected static ?string $title = 'Registros por Departamento';

    public $filter;
    public $registros;
    public $filtroTexto;

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
        $this->filter='anual';
        $this->registros = $this->getRegistros();

    }

    public function getGrafico()
    {
        $depaId = auth()->user()->departamento_id;

        $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', $depaId)
            ->select('registrable_type')
            ->selectRaw('count(*) as total, registrable_type')
            ->groupBy('registrable_type');

        $currentDate = Carbon::now();

        if ($this->filter === 'anual') {
            $query->whereYear('registros.created_at', $currentDate->year);
        } elseif ($this->filter === 'trimestre') {
            $currentQuarter = $currentDate->quarter;
            $query->whereRaw('QUARTER(registros.created_at) = ?', [$currentQuarter]);
        } elseif ($this->filter === 'semestre') {
            $currentMonth = $currentDate->month;
            if ($currentMonth <= 6) {
                $query->whereBetween('registros.created_at', [$currentDate->clone()->startOfYear(), $currentDate->clone()->month(6)->endOfMonth()]);
            } else {
                $query->whereBetween('registros.created_at', [$currentDate->clone()->month(7)->startOfMonth(), $currentDate->clone()->endOfYear()]);
            }
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

        if ($this->filter === 'anual') {
            $query->whereYear('registros.created_at', $currentDate->year);
        } elseif ($this->filter === 'trimestre') {
            $currentQuarter = $currentDate->quarter;
            $query->whereRaw('QUARTER(registros.created_at) = ?', [$currentQuarter]);
        } elseif ($this->filter === 'semestre') {
            $currentMonth = $currentDate->month;
            if ($currentMonth <= 6) {
                $query->whereBetween('registros.created_at', [$currentDate->clone()->startOfYear(), $currentDate->clone()->month(6)->endOfMonth()]);
            } else {
                $query->whereBetween('registros.created_at', [$currentDate->clone()->month(7)->startOfMonth(), $currentDate->clone()->endOfYear()]);
            }
        }


        return $query->get();
    }

    public function generadorPDF()
    {
        $registros = $this->getRegistros();
        $graficoData = $this->getGrafico();
        $anio = Carbon::now()->year;
        $mes = Carbon::now()->month;

        switch($this->filter){
            case('anual'):
                $filtroTexto='Enero - Diciembre '. $anio;
            break;
            case('trimestre'):
                if($mes<=3)
                    $filtroTexto='Trimestre Enero - Marzo '. $anio;
                elseif($mes<=6)
                    $filtroTexto='Trimestre Abril - Junio '. $anio;
                elseif($mes<=9)
                    $filtroTexto='Trimestre Julio - Septiembre '. $anio;
                else
                    $filtroTexto='Trimestre Octubre - Diciembre '. $anio;
            break;
            case('semestre'):
                if($mes<=6)
                    $filtroTexto='Semestre Enero - Junio '. $anio;
                else
                    $filtroTexto='Semestre Julio - Diciembre '. $anio;
            break;
        }

        $html = view('reports.reportes-registros', [
            'registros' => $registros,
            'graficoData' => $graficoData,
            'filtroTexto' => $filtroTexto
        ])->render();


        Browsershot::html($html)
            ->setOption('no-sandbox', true)
            ->setOption('landscape', true)
            ->save(storage_path('app/public/reports/reporte_de_area.pdf'));

        return response()->download(storage_path('app/public/reports/reporte_de_area.pdf'));
    }

}
