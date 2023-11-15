<?php

namespace App\Filament\Resources\AutoralResource\Pages;

use App\Filament\Resources\AutoralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutoral extends EditRecord
{
    protected static string $resource = AutoralResource::class;

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
