<?php

namespace App\Livewire;

use App\Models\Registro;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Tables\Filters\SelectFilter;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class ListRegistros extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
            )
            ->columns([
                TextColumn::make('user.name')->label('Nombre'),
                TextColumn::make('user.apellidos')->label('Apellidos'),
                TextColumn::make('created_at')->date()->label('Fecha de Creación'),
                TextColumn::make('registrable_type')
                ->label('Tipo de Registro')
                ->getStateUsing(function ($record) {
                    switch ($record->registrable_type) {
                        case 'App\Models\Tesis':
                            return 'Tesis';
                        case 'App\Models\Libro':
                            return 'Libro';
                        case 'App\Models\Capitulol':
                            return 'Capítulo de Libro';
                        case 'App\Models\Capitulom':
                            return 'Capítulo de Memoria';
                        case 'App\Models\Autoral':
                            return 'Registro Autoral';
                        case 'App\Models\Prototipo':
                            return 'Prototipo';
                        case 'App\Models\Articulo':
                            return 'Artículo';
                        case 'App\Models\Industrial':
                            return 'Propiedad Intelectual';
                        case 'App\Models\Ponencia':
                            return 'Ponencia';
                        case 'App\Models\Otro':
                            return 'Otro';
                        default:
                            return 'Desconocido';
                    }
                }),
            ])
            ->filters([
                Filter::make('date_filter')
        ->form([
            Select::make('date_range')
                ->options([
                    'today' => 'Hoy',
                    'this_week' => 'Esta Semana',
                    'this_month' => 'Este Mes',
                    'this_quarter' => 'Este Trimestre',
                    'this_year' => 'Este Año',
                ])
                ->reactive(),
        ])
        ->query(fn (Builder $query, array $data) => $this->filtrarRegistros($query, $data['date_range'] ?? null)),
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    protected function filtrarRegistros(Builder $query, $selected)
    {
        if (!$selected) {
            return;
        }

        switch ($selected) {
            case 'today':
                $query->whereDate('registros.created_at', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('registros.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('registros.created_at', Carbon::now()->month);
                break;
            case 'this_quarter':
                $query->whereBetween('registros.created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]);
                break;
            case 'this_year':
                $query->whereYear('registros.created_at', Carbon::now()->year);
                break;
        }
    }
    public function render(): View
    {
        return view('livewire.list-registros');
    }
}
