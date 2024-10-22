<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');

        body {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body class="p-4">

    <h1 class="text-2xl font-bold mb-4">Listado de Registros</h1>
    @livewire('producciondepartamento')
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                <th class="py-3 px-4 border-b">Docente</th>
                <th class="py-3 px-4 border-b">Nombre del Proyecto</th>
                <th class="py-3 px-4 border-b">Fecha de Creación</th>
                <th class="py-3 px-4 border-b">Tipo de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b">{{ $registro->user_name }} {{ $registro->user_apellidos }}</td>
                    <td class="py-2 px-4 border-b">{{ $registro->nombre }}</td>
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
                            @case('App\Models\Articulo')
                                Artículo
                                @break
                            @case('App\Models\Capitulom')
                                Capítulo de Memoria
                                @break
                            @case('App\Models\Autoral')
                                Autoral
                                @break
                            @case('App\Models\Prototipo')
                                Prototipo
                                @break
                            @case('App\Models\Ponencia')
                                Ponencia
                                @break
                            @case('App\Models\Industrial')
                                Propiedad Intelectual
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
</body>
</html>
