<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapitulomResource\Pages;
use App\Filament\Resources\CapitulomResource\RelationManagers;
use App\Models\Capitulom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapitulomResource extends Resource
{
    protected static ?string $model = Capitulom::class;

    protected static ?string $navigationIcon = 'heroicon-s-eye';

    protected static ?string $modelLabel = 'Capitulo Memoria';

    protected static ?string $pluralModelLabel = "Capitulos Memoria";
    
    protected static ?string $slug = "capituloms";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('congreso')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('estado_region')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ciudad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('revision')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagina_fin')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('congreso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado_region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ciudad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('revision')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pagina_inicio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pagina_fin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issn')
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
            'index' => Pages\ListCapituloms::route('/'),
            'create' => Pages\CreateCapitulom::route('/create'),
            'edit' => Pages\EditCapitulom::route('/{record}/edit'),
        ];
    }    
}
