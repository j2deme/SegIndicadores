<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustrialResource\Pages;
use App\Filament\Resources\IndustrialResource\RelationManagers;
use App\Models\Industrial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustrialResource extends Resource
{
    protected static ?string $model = Industrial::class;

    protected static ?string $navigationIcon = 'heroicon-s-wrench-screwdriver';

    protected static ?string $modelLabel = 'Industrial';

    protected static ?string $pluralModelLabel = "Industriales";
    
    protected static ?string $slug = "Industriales";
    public static $tipo_propiedad = [
        'Denominación de origen',
        'Marca',
        'Modelo de utilidad',
        'Patente',];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo')
                ->label("Tipo de propiedad")
                ->options(IndustrialResource::$tipo_propiedad),
                Forms\Components\TextInput::make('clave')
                    ->required()
                    ->maxLength(255)
                    ->label('Clave'),
                Forms\Components\DatePicker::make('fecha_registro')
                ->label("Fecha de Registro")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo')
                ->formatStateUsing(fn(string $state): string => IndustrialResource::$tipo_propiedad[$state])
                    ->searchable(),
                Tables\Columns\TextColumn::make('clave')
                    ->searchable()
                    ->label('Clave'),
                Tables\Columns\TextColumn::make('fecha_registro')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndustrials::route('/'),
            'create' => Pages\CreateIndustrial::route('/create'),
            'edit' => Pages\EditIndustrial::route('/{record}/edit'),
        ];
    }    
}
