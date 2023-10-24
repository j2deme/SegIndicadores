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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pluralModelLabel = "Prototipos";
    
    protected static ?string $slug = "prototipo";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nombre instituto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('Objetivo')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('Caracteristicas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Tipo')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_instituto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('caracteristicas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
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
