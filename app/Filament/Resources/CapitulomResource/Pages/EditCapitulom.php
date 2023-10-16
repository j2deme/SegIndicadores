<?php

namespace App\Filament\Resources\CapitulomResource\Pages;

use App\Filament\Resources\CapitulomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCapitulom extends EditRecord
{
    protected static string $resource = CapitulomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
