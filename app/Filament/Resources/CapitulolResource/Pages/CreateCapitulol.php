<?php

namespace App\Filament\Resources\CapitulolResource\Pages;

use App\Filament\Resources\CapitulolResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;


class CreateCapitulol extends CreateRecord
{
    protected static string $resource = CapitulolResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}

