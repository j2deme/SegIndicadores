<?php

namespace App\Filament\Resources\IndustrialResource\Pages;

use App\Filament\Resources\IndustrialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIndustrial extends CreateRecord
{
    protected static string $resource = IndustrialResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
