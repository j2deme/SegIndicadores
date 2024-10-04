<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class Bienvenida extends BaseWidget
{
    protected function getStats(): array
    {
        $nombre=auth()->user()->name;
        $apellidos=auth()->user()->apellidos;
        //dd($nombre, $apellidos);
        return [
            Stat::make('Bienvenido', "{$nombre} {$apellidos}")
            ->icon('heroicon-o-check-circle'),
        ];
    }
}
