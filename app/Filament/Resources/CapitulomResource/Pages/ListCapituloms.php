<?php

namespace App\Filament\Resources\CapitulomResource\Pages;

use App\Filament\Resources\CapitulomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCapituloms extends ListRecords
{
    protected static string $resource = CapitulomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
