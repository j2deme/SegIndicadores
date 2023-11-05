<?php

namespace App\Filament\Resources\PonenciaResource\Pages;

use App\Filament\Resources\PonenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePonencia extends CreateRecord
{
    protected static string $resource = PonenciaResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
