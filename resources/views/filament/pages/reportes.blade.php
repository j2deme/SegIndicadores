<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<x-filament-panels::page>

    <div class="flex justify-between">

        <div>
            <label for="filtroPeriodo" class="mr-2">Seleccionar periodo:</label>
            <select wire:model="filter" id="filtroPeriodo" class="border rounded px-2 py-1">
                <option value="anual">Anual</option>
                <option value="semestre">Semestre</option>
                <option value="trimestre">Trimestre</option>
            </select>
        </div>

        <x-filament::button wire:click="generadorPDF">Generar Reporte</x-filament::button>
    </div>

    <div class="mt-8">

        <h3 class="text-xl font-semibold">Gráfico de los 5 Docentes con más Registros</h3>
        <canvas id="chartPie"></canvas>
    </div>

    <div class="mt-8">

        <h3 class="text-xl font-semibold">Gráfico de Registros</h3>
        <canvas id="chartBar"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>

            var ctxPie = document.getElementById('chartPie').getContext('2d');
            var pieChartData = {
                labels: @json($registros->take(5)->pluck('autores')),
                datasets: [{
                    label: 'Registros',
                    data: @json($registros->take(5)->pluck('area_conocimiento')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ]
                }]
            };

            new Chart(ctxPie, {
                type: 'bar',
                data: pieChartData,
            });


            var ctxBar = document.getElementById('chartBar').getContext('2d');
            var barChartData = {
                labels: @json($registros->pluck('registrable_type')),
                datasets: [{
                    label: 'Registros',
                    data: @json($registros->groupBy('registrable_type')->map(fn($r) => $r->count())),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                    ]
                }]
            };

            new Chart(ctxBar, {
                type: 'bar',
                data: barChartData,
            });
        </script>
    @endpush


    <div class="mt-8">
        <h3 class="text-xl font-semibold">Listado de registros</h3>
    </div>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2"></th>
               <th class="px-4 py-2">Autores</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Tipo de Registro</th>
                <th class ="px-4 py-2">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $index => $registro)
                <tr>
                    <td>{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $registro->autores }} </td>
                <td class="border px-4 py-2">{{ $registro->nombre }} </td>
                <td class="border px-4 py-2">
                    @switch($registro->registrable_type)
                        @case('App\Models\Tesis')
                            Tesis
                        @break
                        @case('App\Models\Libro')
                            Libro
                        @break
                        @case('App\Models\Capitulol')
                            Capítulo Libro
                        @break
                        @case('App\Models\Articulo')
                            Artículo
                        @break
                        @case('App\Models\Capitulom')
                            Capítulo de Memoria
                        @break
                        @case('App\Models\Industrial')
                            Industrial
                        @break
                        @case('App\Models\Ponencia')
                            Ponencia
                        @break
                        @case('App\Models\Prototipo')
                            Prototipo
                        @break
                        @case('App\Models\Autoral')
                            Registro Autoral
                        @break
                        @case('App\Models\Otro')
                            Otro
                        @default

                    @endswitch
                </td>
                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($registro->created_at)->format('d-m') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</x-filament-panels::page>
