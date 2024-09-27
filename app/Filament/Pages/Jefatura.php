<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\livewire\RegistroStatsOverview;
use App\livewire\TrimisteChart;
use App\livewire\EstadisticaChart;
//use App\Models\Departamento;

class Jefatura extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.jefatura';

    protected function getHeaderWidgets(): array
{
    return [
        RegistroStatsOverview::class,
       TrimisteChart::class,
   
        EstadisticaChart::class,
        
    ];
}
}
