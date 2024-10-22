<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Registro;
use App\Models\Departamento;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Reportes extends Page
{
    //protected static ?string $heading = null;
    protected static ?string $navigationIcon = 'heroicon-s-bookmark-square';
    protected static string $view = 'filament.pages.reportes';
    public $registros;

    public function getHeading():string
    {
        $depaId=auth()->user()->departamento_id;
        $departamento = Departamento::find($depaId);

        return 'Registros del departamento de ' . $departamento->nombre;
    }
        public function getRegistros()
    {
        $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
            ->get();

        return $registros;
    }
}
