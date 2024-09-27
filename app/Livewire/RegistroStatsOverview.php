<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;
  

class RegistroStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Registros Totales',Registro::where('sector_id', function($query) {$query->select('id')->from('Departamentos')->where('jefe_id', auth()->user()->id); })->count())->description('Total de registros de la Jefatura')->Icon('heroicon-o-check-circle')->color('success'),
            Stat::make('Capitulos', Registro::where('sector_id', function($query) {$query->select('id')->from('Departamentos')->where('jefe_id', auth()->user()->id);})->whereIn('registrable_type', ['Database\\Seeders\\Capitulo','App\\Models\\Capitulol'])->count())->description('Total de Capitulos de Area')->Icon('heroicon-o-check-circle')->color('success'),
            Stat::make('Capitulos de memoria', Registro::where('sector_id', function($query) {$query->select('id')->from('Departamentos')->where('jefe_id', auth()->user()->id);})->where('registrable_type', 'Database\\Seeders\\Historias')->count())->description('Total de Capitulos de Historias de Area')->Icon('heroicon-o-check-circle')->color('success'),
            Stat::make('Libros', Registro::where('sector_id', function($query) {$query->select('id')->from('Departamentos')->where('jefe_id', auth()->user()->id);})->where('registrable_type', 'Database\\Seeders\\Libros')->count())->description('Total de libros de Area')->Icon('heroicon-o-check-circle')->color('success'),
        ];
    }
}
