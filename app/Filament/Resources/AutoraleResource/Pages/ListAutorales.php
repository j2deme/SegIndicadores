<?php

namespace App\Filament\Resources\AutoraleResource\Pages;

use App\Filament\Resources\AutoraleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutorales extends ListRecords
{
    protected static string $resource = AutoraleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
