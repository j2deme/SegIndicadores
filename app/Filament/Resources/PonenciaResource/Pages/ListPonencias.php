<?php

namespace App\Filament\Resources\PonenciaResource\Pages;

use App\Filament\Resources\PonenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPonencias extends ListRecords
{
    protected static string $resource = PonenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
