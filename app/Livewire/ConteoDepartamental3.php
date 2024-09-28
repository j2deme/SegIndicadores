<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Departamento;
use App\Models\Registro;

class ConteoDepartamental3 extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Otros',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Otro')
                ->count()
            )
            ->description('Total de Otros Registros')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Ponencias',
                Registro::join('users', 'registros.user_id', '=', 'users.id')
                    ->where('users.departamento_id', auth()->user()->departamento_id)
                    ->where('registros.registrable_type', 'App\Models\Ponencia')
                    ->count()
            )
            ->description('Total de Ponencias')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Prototipos',
                Registro::join('users', 'registros.user_id', '=', 'users.id')
                    ->where('users.departamento_id', auth()->user()->departamento_id)
                    ->where('registros.registrable_type', 'App\Models\Prototipo')
                    ->count()
            )
            ->description('Total de Prototipos')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

        ];
    }
}
