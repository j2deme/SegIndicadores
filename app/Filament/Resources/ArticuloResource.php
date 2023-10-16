<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\Pages;
use App\Filament\Resources\ArticuloResource\RelationManagers;
use App\Models\Articulo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticuloResource extends Resource
{
    protected static ?string $model = Articulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('revista')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('estatus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('volumen')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('indice')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagina_fin')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('casa_editorial')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('revista')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('volumen')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('indice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
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
                Tables\Columns\TextColumn::make('casa_editorial')
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
            'index' => Pages\ListArticulos::route('/'),
            'create' => Pages\CreateArticulo::route('/create'),
            'edit' => Pages\EditArticulo::route('/{record}/edit'),
        ];
    }    
}
