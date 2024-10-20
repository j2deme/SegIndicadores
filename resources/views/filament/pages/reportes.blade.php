<x-filament-panels::page>
    <h1>Listado de Registros</h1>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Usuario</th>
                <th>Fecha de Creación</th>
                <th>Tipo de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ $registro->user->name }} {{ $registro->user->apellidos}}</td>
                    <td style="text-align: center;">{{ $registro->created_at }}</td>
                    <td>
                        @switch($registro->registrable_type)
                            @case('App\Models\Tesis')
                                Tesis
                            @break
                            @case('App\Models\Libro')
                                Libro
                            @break
                            @case('App\Models\Capitulol')
                                Capítulo de Libro
                            @break
                            @case('App\Models\Capitulom')
                                Capítulo de Memoria
                            @break
                            @case('App\Models\Autoral')
                                Registro Autoral
                            @break
                            @case('App\Models\Prototipo')
                                Prototipo
                            @break
                            @case('App\Models\Articulo')
                                Artículo
                            @break
                            @case('App\Models\Industrial')
                                Propiedad Intelectual
                            @break
                            @case('App\Models\Ponencia')
                                Ponencia
                            @break
                            @case('App\Models\Otro')
                                Otro
                            @break
                            @default

                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament-panels::page>
