<?php

namespace App\Filament\Resources\AutoralResource\Pages;

use App\Filament\Resources\AutoralResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAutoral extends CreateRecord
{
    protected static string $resource = AutoralResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
