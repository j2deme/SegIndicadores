<?php

namespace App\Filament\Resources\RegistroResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registro;

class TotalRegistros extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Registros Totales',Registro::where('user_id', auth()->user()->id)->count()),
            
        ];
    }
}
