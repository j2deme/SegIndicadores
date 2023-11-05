<?php

namespace App\Filament\Resources\PrototipoResource\Pages;

use App\Filament\Resources\PrototipoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrototipo extends CreateRecord
{
    protected static string $resource = PrototipoResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
