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
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('rfc')
                    ->label('RFC')
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->hiddenOn('create'),
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
                    ->native(false)
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('titulo')
                    ->hint('Escriba el título completo')
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('cedula')
                    ->hint('Del último grado de estudios')
                    ->label('Cédula Profesional')
                    ->hiddenOn('create'),
                Forms\Components\Select::make('departamento_id')
                    ->label('Departamento de Adscripción')
                    ->relationship('departamento', 'nombre')
                    ->native(false),
                Forms\Components\TextInput::make('jefatura')
                    ->label('Jefatura de Departamento')
                    ->formatStateUsing(fn($state, User $user) => !$user->jefatura ? '-' : $user->jefatura->nombre)
                    ->hiddenOn(['create', 'edit']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre Completo')
                    ->sortable(['name', 'apellidos'])
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('departamento.nombre')
                    ->label('Adscripción')
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jefatura.nombre')
                    ->label('Jefe Depto.')
                    ->wrap()
                    ->default('-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('es_jefe')
                    ->label('Es Jefe')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(fn(Builder $query) => $query->orderBy('name')->orderBy('apellidos'))
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('departamento')
                    ->label('Adscripción')
                    ->attribute('departamento.nombre')
                    ->native(false),
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
