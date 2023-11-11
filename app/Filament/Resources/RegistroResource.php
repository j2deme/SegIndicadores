<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistroResource\Pages;
use App\Filament\Resources\RegistroResource\RelationManagers;
use App\Models\Registro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use App\Models\Subsector;
use Illuminate\Support\Collection;

class RegistroResource extends Resource
{
    protected static ?string $model = Registro::class;

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';

    public static $paises = ["Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda", "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica", "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia", "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Catar", "Chad", "Chile", "China", "Chipre", "Ciudad del Vaticano", "Colombia", "Comoras", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guyana", "Guinea", "Guinea ecuatorial", "Guinea-Bisáu", "Haití", "Honduras", "Hungría", "India", "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall", "Islas Salomón", "Israel", "Italia", "Jamaica", "Japón", "Jordania", "Kazajistán", "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Marruecos", "Mauricio", "Mauritania", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru", "Nepal", "Nicaragua", "Níger", "Nigeria", "Noruega", "Nueva Zelanda", "Omán", "Países Bajos", "Pakistán", "Palaos", "Palestina", "Panamá", "Papúa Nueva Guinea", "Paraguay", "Perú", "Polonia", "Portugal", "Reino Unido", "República Centroafricana", "República Checa", "República de Macedonia", "República del Congo", "República Democrática del Congo", "República Dominicana", "República Sudafricana", "Ruanda", "Rumanía", "Rusia", "Samoa", "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam", "Tailandia", "Tanzania", "Tayikistán", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Zambia", "Zimbabue"];

    public static $propositos = ["Asimilación de Tecnología", "Creación", "Desarrollo Tecnológico", "Difusión", "Generación de Conocimiento", "Investigación Aplicada", "Transferencia de Tecnología"];

    public static $areas_prioritarias = ["Salud", "Química", "Mecánica", "Electrica", "Bioquímica", "Computación", "Agropecuarias", "Administración"];

    public static $areas_conocimiento = ["Ciencias Agrícolas y Forestales", "Ciencias Biológicas", "Ciencias de la Computación, Sistemas Computacionales, Informática", "Ciencias de la Educación", "Ciencias de la Tierra y del Medio Ambiente", "Ciencias de los Materiales,Polímeros", "Ciencias del Mar", "Ciencias Químicas", "Ingeniería Eléctrica, Electrónica", "Ingenieria Industrial, Administración y Desarrollo Regional", "Ingeniería Mecánica, Mecatrónica", "Ingeniería Química, Bioquímica, Alimentos, Biotecnología"];

    protected static ?string $modelLabel = 'Registro';

    protected static ?string $pluralModelLabel = "Registros";

    protected static ?string $slug = "Registros";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label("Propietario")
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('proposito')
                    ->label('Propósito')
                    ->options(RegistroResource::$propositos),
                Forms\Components\TextInput::make('autores')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('posicion_autor')
                    ->label('Posición Autor')
                    ->options([
                        '1' => 'Primer autor',
                        '2' => 'Segundo autor',
                        '3' => 'Tercer autor',
                        '4' => 'Cuarto autor',
                        '5' => 'Quinto autor',
                    ]),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('sector_id')
                    ->relationship('sector', 'nombre')
                    ->live(),
                Forms\Components\Select::make('subsector_id')
                    ->label('Subsector')
                    ->options(fn(Get $get): Collection => Subsector::query()
                        ->where('sector_id', $get('sector_id'))
                        ->pluck('nombre', 'id')),
                Forms\Components\Select::make('area_prioritaria_pais')
                    ->label('Área Prioritaria')
                    ->options(RegistroResource::$areas_prioritarias),
                Forms\Components\Select::make('area_conocimiento')
                    ->label('Área de Conocimiento')
                    ->options(RegistroResource::$areas_conocimiento),
                Forms\Components\DatePicker::make('fecha_publicacion')
                    ->label('Fecha de Publicación'),
                Forms\Components\Select::make('pais_publicacion')
                    ->label('País de Publicación')
                    ->searchable()
                    ->options(RegistroResource::$paises),
                Forms\Components\FileUpload::make('evidencia')
                    ->multiple()
                    ->label('Evidencia'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('proposito')
                    ->formatStateUsing(fn(string $state): string => RegistroResource::$propositos[$state])
                    ->searchable()
                    ->label('Propósito'),
                Tables\Columns\TextColumn::make('autores')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('posicion_autor')
                    ->formatStateUsing(function ($state) {
                        if (in_array($state, [1, 3])) {
                            return $state . "er";
                        }if ($state = 2) {
                            return $state . "do";
                        } else {
                            return $state . "to";
                        }
                    })
                    ->sortable()
                    ->label('Posición Autor')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sector.nombre')
                    ->label('Sector')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subsector.nombre')
                    ->label('Subsector')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('area_prioritaria_pais')
                    ->formatStateUsing(fn(string $state): string => RegistroResource::$areas_prioritarias[$state])
                    ->searchable()
                    ->label('Área Prioritaria'),
                Tables\Columns\TextColumn::make('area_conocimiento')
                    ->formatStateUsing(fn(string $state): string => RegistroResource::$areas_conocimiento[$state])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fecha_publicacion')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Fecha de Publicación'),
                Tables\Columns\TextColumn::make('pais_publicacion')
                    ->formatStateUsing(fn(string $state): string => RegistroResource::$paises[$state])
                    ->searchable()
                    ->label('País de Publicación'),
                Tables\Columns\TextColumn::make('evidencia')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Evidencia'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListRegistros::route('/'),
            'create' => Pages\CreateRegistro::route('/create'),
            'edit' => Pages\EditRegistro::route('/{record}/edit'),
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
