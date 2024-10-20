<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Registro;

class Reportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reportes';

    public $registros;
    public function mount()
    {
        $this->registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->get();

         dd($this->registros);

    }

}
