<?php

namespace App\Filament\Resources\OtroResource\Pages;

use App\Filament\Resources\OtroResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOtro extends CreateRecord
{
    protected static string $resource = OtroResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
