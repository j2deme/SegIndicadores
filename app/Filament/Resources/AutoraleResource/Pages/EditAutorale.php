<?php

namespace App\Filament\Resources\AutoraleResource\Pages;

use App\Filament\Resources\AutoraleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutorale extends EditRecord
{
    protected static string $resource = AutoraleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
