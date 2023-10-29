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
    
    protected static ?string $slug = "prototipo";

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
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('caracteristicas')
                ->label("Características")
                
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tipo')
                ->label("Tipo de prototipo")
                ->options([
                    'arquitectonico' => 'Arquitectónico',
                    'programa de computo' => 'Programa de computo',
                    'diseño industrial' => 'Diseño industrial',
                    'desarrollo industrial' => 'Desarrollo industrial',
                    
                ])
                
                    
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
