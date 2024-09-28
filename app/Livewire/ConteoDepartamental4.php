<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Departamento;
use App\Models\Registro;

class ConteoDepartamental4 extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Tesis',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Tesis')
                ->count()
            )
            ->description('Total de Tesis')
            ->icon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Propiedades Intelectuales',
            Registro::join('users', 'registros.user_id', '=', 'users.id')
                ->where('users.departamento_id', auth()->user()->departamento_id)
                ->where('registros.registrable_type', 'App\Models\Industrial')
                ->count()
            )
            ->description('Total de Prop. Intelectuales')
            ->icon('heroicon-o-check-circle')
            ->color('success'),
        ];
    }
}
