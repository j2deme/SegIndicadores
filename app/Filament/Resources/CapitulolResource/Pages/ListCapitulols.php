<?php

namespace App\Filament\Resources\CapitulolResource\Pages;

use App\Filament\Resources\CapitulolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCapitulols extends ListRecords
{
    protected static string $resource = CapitulolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
