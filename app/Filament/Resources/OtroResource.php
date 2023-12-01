<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OtroResource\Pages;
use App\Filament\Resources\OtroResource\RelationManagers;
use App\Models\Otro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistroResource;
use App\Models\User;

class OtroResource extends Resource
{
    protected static ?string $model = Otro::class;

    protected static ?string $navigationIcon = 'heroicon-s-squares-plus';

    protected static ?string $navigationGroup = 'Extensión';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Otro';

    protected static ?string $pluralModelLabel = "Otros";

    protected static ?string $slug = "Otros";

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
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255)
                    ->label('Título'),
                    ]),
             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->label('Título'),
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
            'index' => Pages\ListOtros::route('/'),
            'create' => Pages\CreateOtro::route('/create'),
            'edit' => Pages\EditOtro::route('/{record}/edit'),
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
