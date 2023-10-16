<?php

namespace App\Filament\Resources\IndustrialResource\Pages;

use App\Filament\Resources\IndustrialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndustrials extends ListRecords
{
    protected static string $resource = IndustrialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
