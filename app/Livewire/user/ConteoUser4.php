<?php

namespace App\Livewire\user;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;

class ConteoUser4 extends BaseWidget
{
    protected function getStats(): array
    {   $user=auth()->user()->es_admin;
        if($user==1){
            return[
                Stat::make('Prop. Intelectuales',
                Registro::where('registrable_type', 'App\Models\Industrial')
                ->count())->description('Total de Prop. Intelectuales')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Tesis',
                Registro::all()
                ->where('registrable_type', 'App\Models\Tesis')
                ->count())
                ->description('Total de Tesis')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }else{
            return[
                Stat::make('Prop. Intelectuales',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Industrial')
                ->count())
                ->description('Total de Otros Prop. Intelectuales')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Tesis',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Tesis')
                ->count())
                ->description('Total de Ponencias')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }
    }
}
