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

    protected static ?string $navigationIcon = 'heroicon-s-newspaper';

    protected static ?string $navigationGroup = 'Investigación';

    protected static ?string $modelLabel = 'Artículo';

    protected static ?string $pluralModelLabel = "Artículos";

    protected static ?string $slug = "Articulos";

    public static $estatus = ["Sometido", "Aceptado", "Publicado"];

    public static $tipos = ["Divulgación", "Arbitrado", "Indexado"];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('revista')
                    ->label('Revista')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('estatus')
                    ->label('Estatus')
                    ->required()
                    ->options(ArticuloResource::$estatus)
                    ->native(false),
                Forms\Components\Select::make('tipo')
                    ->label('Tipo')
                    ->required()
                    ->options(ArticuloResource::$tipos)
                    ->native(false),
                Forms\Components\TextInput::make('volumen')
                    ->label('Volumen')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('indice')
                    ->label('Índice')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->label('Página Inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagina_fin')
                    ->label('Página Fin')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('casa_editorial')
                    ->label('Casa Editorial')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('revista')
                    ->searchable()
                    ->label('Revista'),
                Tables\Columns\TextColumn::make('estatus')
                    ->searchable()
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable()
                    ->label('Tipo'),
                Tables\Columns\TextColumn::make('volumen')
                    ->numeric()
                    ->label('Volumen')
                    ->formatStateUsing(fn(string $state): string => ArticuloResource::$estatus[$state])
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->formatStateUsing(fn(string $state): string => ArticuloResource::$tipos[$state])
                    ->searchable(),
                Tables\Columns\TextColumn::make('volumen')
                    ->numeric(),
                Tables\Columns\TextColumn::make('indice')
                    ->searchable()
                    ->label('Índice'),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pagina_inicio')
                    ->numeric()
                    ->sortable()
                    ->label('Página Inicio'),
                Tables\Columns\TextColumn::make('pagina_fin')
                    ->numeric()
                    ->sortable()
                    ->label('Página Fin'),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issn')
                    ->label('ISSN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('casa_editorial')
                    ->searchable()
                    ->label('Casa Editorial'),
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

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()->es_admin;
    }

    public static function canViewAny(): bool
    {
        return !auth()->user()->es_admin;
    }
}
