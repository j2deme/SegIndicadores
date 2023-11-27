<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TesisResource\Pages;
use App\Filament\Resources\TesisResource\RelationManagers;
use App\Models\Tesis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistroResource;
use App\Models\User;

class TesisResource extends Resource
{
    protected static ?string $model = Tesis::class;

    protected static ?string $navigationIcon = 'heroicon-s-pencil-square';

    protected static ?string $navigationGroup = 'Investigación';

    protected static ?string $modelLabel = 'Tesis';

    protected static ?string $pluralModelLabel = "Tesis";

    protected static ?string $slug = "Tesis";

    public static $grado = ['Licenciatura', 'Especialización', 'Maestría', 'Doctorado', 'Posdoctorado'];

    public static $estatus = ['En proceso', 'Trunca', 'Concluida'];

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
                    ->collapsible()
                    ->schema([

                Forms\Components\Grid::make()
                        ->schema([
                
                Forms\Components\Select::make('grado')
                    ->options(TesisResource::$grado)
                    ->label('Grado'),

                Forms\Components\Select::make('estatus')
                    ->options(TesisResource::$estatus)
                    ->label('Estatus'),
                    ])
                    ])
                    ->columns(2)
                
              ]);
                
           
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grado')
                    ->formatStateUsing(fn(string $state): string => TesisResource::$grado[$state])
                    ->label('Grado'),

                Tables\Columns\TextColumn::make('estatus')
                    ->formatStateUsing(fn(string $state): string => TesisResource::$estatus[$state])
                    ->label('Estatus'),
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
            'index' => Pages\ListTesis::route('/'),
            'create' => Pages\CreateTesis::route('/create'),
            'edit' => Pages\EditTesis::route('/{record}/edit'),
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
