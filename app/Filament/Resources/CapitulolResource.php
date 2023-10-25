<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapitulolResource\Pages;
use App\Filament\Resources\CapitulolResource\RelationManagers;
use App\Models\Capitulol;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapitulolResource extends Resource
{
    protected static ?string $model = Capitulol::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $modelLabel = 'Capitulo Libro';
    
    protected static ?string $pluralModelLabel = "Capitulos Libro";
    
    protected static ?string $slug = "capitulols";

    protected static?string $recordTitleAttribute = "text";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('libro')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255)
                    ->label('ISBN'),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')     
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
                Tables\Columns\TextColumn::make('libro')
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
            'index' => Pages\ListCapitulols::route('/'),
            'create' => Pages\CreateCapitulol::route('/create'),
            'edit' => Pages\EditCapitulol::route('/{record}/edit'),
        ];
    }    
}
