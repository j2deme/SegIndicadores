<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;

class TotalRegistros extends BaseWidget
{
    protected function getStats(): array
    {
        $user=auth()->user()->es_admin;
        if($user==1){
            return[
                Stat::make('Registros Totales', Registro::all()->count()),
            ];
        }else{
            return[
                Stat::make('Registros Totales', Registro::where('user_id', auth()->user()->id)->count()),
            ];
        }
    }
}
