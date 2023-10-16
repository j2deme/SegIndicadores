<?php

namespace App\Filament\Resources\PrototipoResource\Pages;

use App\Filament\Resources\PrototipoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrototipos extends ListRecords
{
    protected static string $resource = PrototipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
