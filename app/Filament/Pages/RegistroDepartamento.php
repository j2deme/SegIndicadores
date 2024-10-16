<?php

namespace App\Filament\Pages;
use Filament\Pages\Page;
use App\Models\Departamento;

class RegistroDepartamento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.registro-departamento';
    protected static ?string $title = 'Registros por Departamento';

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

}
