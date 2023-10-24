<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PonenciaResource\Pages;
use App\Filament\Resources\PonenciaResource\RelationManagers;
use App\Models\Ponencia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PonenciaResource extends Resource
{
    protected static ?string $model = Ponencia::class;

    protected static ?string $navigationIcon = 'heroicon-s-presentation-chart-line';

    protected static ?string $pluralModelLabel = "Ponencias";
    
    protected static ?string $slug = "ponencia";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Evento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('Fecha evento')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('evento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_evento')
                    ->date()
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
            'index' => Pages\ListPonencias::route('/'),
            'create' => Pages\CreatePonencia::route('/create'),
            'edit' => Pages\EditPonencia::route('/{record}/edit'),
        ];
    }    
}
