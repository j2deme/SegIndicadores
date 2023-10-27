<?php

namespace App\Filament\Resources\ArticuloResource\Pages;

use App\Filament\Resources\ArticuloResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticulo extends CreateRecord
{
    protected static string $resource = ArticuloResource::class;

    protected static ?string $modelLabel = 'crear articulo';
  protected static ?string $pluralModelLabel = 'Médicos';
  protected static ?string $slug = 'CreateArticulo';
    
}
