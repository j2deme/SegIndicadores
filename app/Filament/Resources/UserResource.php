<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = "Usuarios";

    protected static ?string $slug = "usuarios";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('apellidos')
                    ->label('Apellidos')
                    ->required(),
                Forms\Components\TextInput::make('curp')
                    ->label('CURP')
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\TextInput::make('rfc')
                    ->label('RFC')
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required()
                    ->hiddenOn(Pages\EditUser::class),
                Forms\Components\Select::make('grado_estudios')
                    ->label('Grado de Estudios')
                    ->options([
                        'Licenciatura' => 'Licenciatura',
                        'Maestría' => 'Maestría',
                        'Doctorado' => 'Doctorado',
                        'Postdoctorado' => 'Postdoctorado',
                        'Especialidad' => 'Especialidad',
                    ])
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\TextInput::make('titulo')
                    ->hint('Escriba el título completo')
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\TextInput::make('cedula')
                    ->hint('Del último grado de estudios')
                    ->label('Cédula Profesional')
                    ->hiddenOn(Pages\CreateUser::class),
                Forms\Components\Select::make('departamento_id')
                    ->label('Departamento de Adscripción')
                    ->relationship('departamento', 'nombre')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellidos')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('curp')
                    ->label('CURP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grado_estudios')
                    ->label('Grado de Estudios')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('departamento.nombre')
                    ->label('Departamento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('es_admin')
                    ->label('Administrador')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->emptyStateDescription('');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('es_admin', false);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->es_admin;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->es_admin;
    }
}
