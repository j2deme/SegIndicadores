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
use App\Filament\Resources\RegistroResource;
use App\Models\User;

class CapitulolResource extends Resource
{
    protected static ?string $model = Capitulol::class;

    protected static ?string $navigationIcon = 'heroicon-s-book-open';

    protected static ?string $navigationGroup = 'Investigación';

    protected static ?string $modelLabel = 'Capítulo de Libro';

    protected static ?string $pluralModelLabel = "Capítulos de Libro";

    protected static ?string $slug = "Capitulos-Libro";

    protected static ?string $recordTitleAttribute = "text";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(auth()->user()->id),

                Forms\Components\Section::make('Información de Registro')
                    ->relationship('registro')
                    ->schema(RegistroResource::form($form)->getComponents())
                    ->columns(2),

                    Forms\Components\Section::make('Información Adicional')
                
                ->schema([

                    Forms\Components\Grid::make()
                    ->schema([
                Forms\Components\TextInput::make('libro')
                    ->required()
                    ->maxLength(255),
                   
                   
                    Forms\Components\TextInput::make('casa_editorial')
                    ->label('Casa Editorial')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('edicion')
                    ->label('Edición')
                    ->required(),
                    ])
                    ->columns(2),

                    Forms\Components\Grid::make()
                    ->schema([

                Forms\Components\TextInput::make('pagina_inicio')
                    ->label('Página Inicio')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('pagina_fin')
                    ->label('Página Fin')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(13)
                    ->label('ISBN'),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')
                    ->maxLength(13),
                    ])
                    ->columns(4),
               

                   

                ])

                    
              ]);           
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('libro')
                    ->searchable()
                    ->label('Libro'),
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
                Tables\Columns\TextColumn::make('edicion')
                    ->numeric()
                    ->label('Edición'),
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
