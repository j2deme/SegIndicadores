<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Departamento;
use App\Models\Registro;

class ConteoDepartamental extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Registros Totales',
                Registro::join('users', 'registros.user_id', '=', 'users.id')
                    ->where('users.departamento_id', auth()->user()->departamento_id)
                    ->count()
            )->icon('heroicon-o-check-circle'),
            Stat::make('Articulo',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Articulo')
                ->count()
            )
            ->description('Total de Artículos')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Autorales',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Autoral')
                ->count()
            )
            ->description('Total de Registros Autorales')
            ->icon('heroicon-o-check-circle')
            ->color('success'),


        ];
    }
}
