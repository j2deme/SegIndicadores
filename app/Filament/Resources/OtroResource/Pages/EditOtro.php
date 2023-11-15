<?php

namespace App\Filament\Resources\OtroResource\Pages;

use App\Filament\Resources\OtroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOtro extends EditRecord
{
    protected static string $resource = OtroResource::class;

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
