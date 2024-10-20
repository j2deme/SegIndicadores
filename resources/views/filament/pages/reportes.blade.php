<x-filament-panels::page>
    <div class="overflow-x-auto w-full">

        <table class="min-w-full w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 border-b">No.</th>
                    <th class="py-3 px-4 border-b">Usuario</th>
                    <th class="py-3 px-4 border-b">Fecha de Creación</th>
                    <th class="py-3 px-4 border-b">Tipo de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->getRegistros() as $registro)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $registro->user->name }} {{$registro->user->apellidos}}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($registro->created_at)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4 border-b">
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
    </div>
</x-filament-panels::page>
