<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrototipoResource\Pages;
use App\Filament\Resources\PrototipoResource\RelationManagers;
use App\Models\Prototipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrototipoResource extends Resource
{
    protected static ?string $model = Prototipo::class;

    protected static ?string $navigationIcon = 'heroicon-s-beaker';
    
    protected static ?string $modelLabel = 'Prototipo';

    protected static ?string $pluralModelLabel = "Prototipos";
    
    protected static ?string $slug = "Prototipo";

    public static $tipo_prototipo = [
    'Arquitectónico',
    'Programa de computo',
    'Diseño industrial' ,
    'Desarrollo industrial',];


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_instituto')
                    ->label("Nombre Instituto")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('objetivo')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Objetivo'),
                Forms\Components\TextInput::make('caracteristicas')
                ->label("Características")
                
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tipo')
                ->label("Tipo de prototipo")
                ->options(PrototipoResource::$tipo_prototipo),
                
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_instituto')
                    ->searchable()
                    ->label('Nombre del Instituto'),
                
                    
                Tables\Columns\TextColumn::make('caracteristicas')
                    ->searchable()
                    ->label('Características'),
                
                Tables\Columns\TextColumn::make('tipo')
                ->formatStateUsing(fn(string $state): string => PrototipoResource::$tipo_prototipo[$state])
                    ->searchable()
                    ->label('Tipo'),
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
            'index' => Pages\ListPrototipos::route('/'),
            'create' => Pages\CreatePrototipo::route('/create'),
            'edit' => Pages\EditPrototipo::route('/{record}/edit'),
        ];
    }    
}
