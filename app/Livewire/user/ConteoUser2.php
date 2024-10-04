<?php

namespace App\Livewire\user;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;
class ConteoUser2 extends BaseWidget
{
    protected function getStats(): array
    {   $user=auth()->user()->es_admin;
        if($user==1){
            return[
                Stat::make('Cap. de Libro',
                Registro::where('registrable_type', 'App\Models\Capitulol')
                ->count())->description('Total de Capítulos de Libro')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Cap. de Memoria',
                Registro::all()
                ->where('registrable_type', 'App\Models\Capitulom')
                ->count())
                ->description('Total de Cap. de Memoria')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Libros',
                Registro::all()
                ->where('registrable_type', 'App\Models\Libro')
                ->count())
                ->description('Total de Libros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }else{
            return[
                Stat::make('Cap. de Libro',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Capitulol')
                ->count())
                ->description('Total de Cap. de Libro')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Cap. de Memoria',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Capitulom')
                ->count())
                ->description('Total de Cap. de Memoria')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Libros',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Libro')
                ->count())
                ->description('Total de Libros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }
    }
}
