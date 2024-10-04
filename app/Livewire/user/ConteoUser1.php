<?php

namespace App\Livewire\user;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;
class ConteoUser1 extends BaseWidget
{
    protected function getStats(): array
    {   $user=auth()->user()->es_admin;
        if($user==1){
            return[
                Stat::make('Registros Totales',
                Registro::all()
                ->count())->description('Total de Registros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Articulo',
                Registro::all()
                ->where('registrable_type', 'App\Models\Articulo')
                ->count())
                ->description('Total de Artículos')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Autorales',
                Registro::all()
                ->where('registrable_type', 'App\Models\Autoral')
                ->count())
                ->description('Total de Registros Autorales')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }else{
            return[
                Stat::make('Registros Totales',
                Registro::where('user_id', auth()->user()->id)
                ->count())
                ->description('Total de Registros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Articulo',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Articulo')
                ->count())
                ->description('Total de Artículos')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Autorales',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Autoral')
                ->count())
                ->description('Total de Registros Autorales')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }
    }
}
