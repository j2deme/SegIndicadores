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
use App\Filament\Resources\RegistroResource;
use App\Models\User;

class LibroResource extends Resource
{
    protected static ?string $model = Libro::class;

    protected static ?string $navigationIcon = 'heroicon-s-bookmark-square';

    protected static ?string $navigationGroup = 'Investigación';

    protected static ?string $modelLabel = 'Libro';

    protected static ?string $pluralModelLabel = "Libros";

    protected static ?string $slug = "Libros";


    public static $tipo_participacion = ['Autor', 'Editor', 'Traductor'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Hidden::make('user_id')
                ->default(auth()->user()->id),
                Forms\Components\Select::make('tipo_participacion_autor')
                    ->required()
                    ->options(LibroResource::$tipo_participacion)
                    ->label("Tipo de Participación"),
                Forms\Components\TextInput::make('paginas')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label("No. de Páginas"),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255)
                    ->label("ISBN"),
                Forms\Components\TextInput::make('issn')
                    ->maxLength(255)
                    ->label("ISSN"),
                Forms\Components\TextInput::make('casa_editorial')
                    ->required()
                    ->maxLength(255)
                    ->label("Casa Editorial"),
                Forms\Components\TextInput::make('edicion')
                    ->required()
                    ->numeric()
                    ->label("Edición"),
                Forms\Components\Section::make('Información de Registro')
                    ->relationship('registro')
                    ->schema(RegistroResource::form($form)->getComponents())
                    ->columns(2),
             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               

                Tables\Columns\TextColumn::make('tipo_participacion_autor')
                    ->sortable()
                    ->label("Tipo de Participación")
                    ->formatStateUsing(fn(string $state): string => LibroResource::$tipo_participacion[$state]),
                Tables\Columns\TextColumn::make('paginas')
                    ->numeric()
                    ->sortable()
                    ->label("No. de Páginas"),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable()
                    ->label("ISBN"),
                Tables\Columns\TextColumn::make('issn')
                    ->searchable()
                    ->label("ISSN"),
                Tables\Columns\TextColumn::make('casa_editorial')
                    ->searchable()
                    ->label("Casa Editorial"),
                Tables\Columns\TextColumn::make('edicion')
                    ->numeric()
                    ->sortable()
                    ->label("Edición"),
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
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
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
