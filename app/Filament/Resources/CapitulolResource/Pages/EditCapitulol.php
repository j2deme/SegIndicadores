<?php

namespace App\Filament\Resources\CapitulolResource\Pages;

use App\Filament\Resources\CapitulolResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCapitulol extends EditRecord
{
    protected static string $resource = CapitulolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
