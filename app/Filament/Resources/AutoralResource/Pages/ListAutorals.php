<?php

namespace App\Filament\Resources\AutoralResource\Pages;

use App\Filament\Resources\AutoralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutorals extends ListRecords
{
    protected static string $resource = AutoralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
