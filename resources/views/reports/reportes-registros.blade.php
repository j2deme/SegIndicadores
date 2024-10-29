<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

    header {
        display: flex;
    }
    .logo{
        display: flex;
    }
    .logo img{
        height: 90px;
    }

        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #010000;
        }
        canvas {
            display: block;
            margin: 0 auto;
            max-width: 600px;
            max-height: 400px;
            width: 100%;
            height: auto;
}

    </style>
</head>
<body>
    <header style="text-align: center;">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logotec2.png'))) }}" alt="Logo" style="width: auto; height: auto; margin-bottom: 10px;">

            <div style="text-align: center;">
                <h2 style="margin: 0;">Reporte de producción del Departamento de {{ auth()->user()->departamento->nombre }}</h2>
                <h2 style="margin: 5px 0 0;">{{ $filtroTexto }}</h2>
            </div>
        </div>
    </header>


    <h2 style="text-align: center;">Tabla de registros totales</h2>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Autor</th>
                <th >Nombre</th>
                <th>Tipo de Registro</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $index => $registro)
            <tr>
                <td>{{ $index + 1 }}</td>
                    <td>{{ $registro->user_name }} {{ $registro->user_apellidos }}</td>
                    <td>{{ $registro->nombre }}</td>
                    <td>@switch($registro->registrable_type)
                        @case('App\Models\Libro')
                            Libro
                        @break
                        @case('App\Models\Capitulol')
                            Capítulo de Libro
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
                            Prop. Intelectual
                        @break
                        @case('App\Models\Ponencia')
                            Ponencia
                        @break
                        @case('App\Models\Tesis')
                            Tesis
                        @break
                        @case('App\Models\Otro')
                            Otro
                        @break
                        @case('App\Models\Capitulom')
                            Capitulo de Memoria
                        @break
                        @default

                    @endswitch
                    </td>
                    <td style="width: 75px;">{{ $registro->created_at->format('d-M')  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="page-break-before: always;"></div>

    <h3 style="text-align: center;" class="text-xl font-semibold">Gráfico de Registros</h3><br>
    <canvas id="chart" width="70%" height="50%"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chart').getContext('2d');
    var chartData = {
        labels: @json($graficoData->pluck('registrable_type')),
        datasets: [{
            label: 'Registros',
            data: @json($graficoData->pluck('total')),
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ]
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
