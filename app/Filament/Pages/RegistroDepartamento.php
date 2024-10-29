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


    public function getHeading(): string
    {
        $departamentoNombre = auth()->user()->departamento->nombre;
        return "Departamento: " . $departamentoNombre;
    }
    // public function getInfo(): string
    // {
    //     $departamentoNombre = auth()->user()->departamento->nombre;
    //     return "Registro del departamento de: " . $departamentoNombre;
    // }
   
    



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
        ->selectRaw('COUNT(*) as total') 
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
            $query->whereBetween('registros.created_at', [$currentDate->startOfYear(), $currentDate->copy()->endOfMonth(6)]);
        } else {
            $query->whereBetween('registros.created_at', [$currentDate->copy()->startOfMonth(7), $currentDate->endOfYear()]);
        }
    }

    return $query->get(); 
}
public function getRegistros()
{
    $depaId = auth()->user()->departamento_id;
    $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', $depaId)
        ->select('registrable_type', 'registros.created_at', 'autores', 'nombre');

    $currentDate = Carbon::now();

    if ($this->filter === 'anual') {
        $query->whereYear('registros.created_at', $currentDate->year);
    } elseif ($this->filter === 'trimestre') {
        $currentQuarter = $currentDate->quarter;
        $query->whereRaw('QUARTER(registros.created_at) = ?', [$currentQuarter]);
    } elseif ($this->filter === 'semestre') {
        $currentMonth = $currentDate->month;
        if ($currentMonth <= 6) {
            $query->whereBetween('registros.created_at', [$currentDate->startOfYear(), $currentDate->copy()->endOfMonth(6)]);
        } else {
            $query->whereBetween('registros.created_at', [$currentDate->copy()->startOfMonth(7), $currentDate->endOfYear()]);
        }
    }

    return $query->get();
}



    
    
    public function generadorPDF()
    {
        
        $registros = $this->getRegistros();
        $graficoData = $this->getGrafico();
    
        $html = view('reports.reportes-registros', [
            'registros' => $registros,
            'graficoData' => $graficoData
        ])->render();
    
        
        Browsershot::html($html)
            ->setOption('no-sandbox', true) 
            ->save(storage_path('app/public/reports/reporte_de_area.pdf')); 
    
        return response()->download(storage_path('app/public/reports/reporte_de_area.pdf'));
    }
    
    

}
