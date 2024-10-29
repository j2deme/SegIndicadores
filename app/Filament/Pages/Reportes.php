<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Registro;
use App\Models\Departamento;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class Reportes extends Page
{
    //protected static ?string $heading = null;
    protected static ?string $navigationIcon = 'heroicon-s-bookmark-square';
    protected static string $view = 'filament.pages.reportes';
    public $selectedFilter = '';
    public $filter;


    public $registros;

    public function getHeading():string
    {
        $depaId=auth()->user()->departamento_id;
        $departamento = Departamento::find($depaId);

        return 'Registros del departamento de ' . $departamento->nombre;
    }


    public function mount(){
        $this->filter='anual';
        $this->registros = $this->getRegistros();

    }


    public function getRegistros()
    {
        $depaId=auth()->user()->departamento_id;
        // $query = Registro::where('sector_id', $depaId)
        // ->select(
        //     'registrable_type',
        //     'created_at',
        //     'autores',
        //     'nombre'
        // );
        $query = Registro::join('users', 'registros.user_id', '=', 'users.id')
        ->where('users.departamento_id', auth()->user()->departamento_id)
        ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
;

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
         $html = view('reports.reportes-registros', ['registros' => $registros])->render();

        Browsershot::html($html)
            ->setOption('no-sandbox', true)
            ->save(storage_path('app/public/reports/reporte de area.pdf'));

            return response()->download(storage_path('app/public/reports/reporte de area.pdf'));

    }
    public static function shouldRegisterNavigation(): bool{
        return false;
    }

}

