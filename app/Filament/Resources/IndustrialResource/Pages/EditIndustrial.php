<?php

namespace App\Filament\Resources\IndustrialResource\Pages;

use App\Filament\Resources\IndustrialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndustrial extends EditRecord
{
    protected static string $resource = IndustrialResource::class;

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
