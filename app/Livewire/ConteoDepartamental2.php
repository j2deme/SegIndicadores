<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Departamento;
use App\Models\Registro;

class ConteoDepartamental2 extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Capítulos de Libro',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Capitulol')
                ->count()
            )
            ->description('Total de Capítulos de Libro')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Capítulos de Memoria',
                Registro::join('users', 'registros.user_id', '=', 'users.id')
                    ->where('users.departamento_id', auth()->user()->departamento_id)
                    ->where('registros.registrable_type', 'App\Models\Capitulom')
                    ->count()
            )
            ->description('Total de Capítulos de Memoria')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Libros',
                Registro::join('users', 'registros.user_id', '=', 'users.id')
                    ->where('users.departamento_id', auth()->user()->departamento_id)
                    ->where('registros.registrable_type', 'App\Models\Libro')
                    ->count()
            )
            ->description('Total de Otros Registros')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

        ];
    }
}
