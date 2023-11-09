<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibroResource\Pages;
use App\Filament\Resources\LibroResource\RelationManagers;
use App\Models\Libro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LibroResource extends Resource
{
    protected static ?string $model = Libro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipo_participacion_autor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('paginas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('casa_editorial')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('edicion')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo_participacion_autor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paginas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('casa_editorial')
                    ->searchable(),
                Tables\Columns\TextColumn::make('edicion')
                    ->numeric()
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
            'index' => Pages\ListLibros::route('/'),
            'create' => Pages\CreateLibro::route('/create'),
            'edit' => Pages\EditLibro::route('/{record}/edit'),
        ];
    }    
}
