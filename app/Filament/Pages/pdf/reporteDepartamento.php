<?php

namespace App\Filament\Pages\pdf;

use Filament\Pages\Page;

class reporteDepartamento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pdf.reporte-departamento';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
