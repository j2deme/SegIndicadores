<?php

namespace App\Livewire\user;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;

class ConteoUser3 extends BaseWidget
{
    protected function getStats(): array
    {   $user=auth()->user()->es_admin;
        if($user==1){
            return[
                Stat::make('Otros',
                Registro::where('registrable_type', 'App\Models\Otro')
                ->count())->description('Total de Otros Registros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Ponencias',
                Registro::all()
                ->where('registrable_type', 'App\Models\Ponencia')
                ->count())
                ->description('Total de Ponencias')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Prototipos',
                Registro::all()
                ->where('registrable_type', 'App\Models\Prototipo')
                ->count())
                ->description('Total de Prototipos')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }else{
            return[
                Stat::make('Otros',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Otro')
                ->count())
                ->description('Total de Otros Regsitros')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Ponencias',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Ponencia')
                ->count())
                ->description('Total de Ponencias')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

                Stat::make('Prototipos',
                Registro::where('user_id', auth()->user()->id)
                ->where('registrable_type', 'App\Models\Prototipo')
                ->count())
                ->description('Total de Prototipos')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            ];
        }
    }
}
