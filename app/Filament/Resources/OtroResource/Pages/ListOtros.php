<?php

namespace App\Filament\Resources\OtroResource\Pages;

use App\Filament\Resources\OtroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOtros extends ListRecords
{
    protected static string $resource = OtroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
