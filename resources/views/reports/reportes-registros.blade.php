<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @page {
            margin-bottom: 40px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            text-align: center;
        }

        .footer img {
            width: 80%;
            height: 75px;
            margin-top: 5px;
        }

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
        tr {
            page-break-inside: avoid;
        }
        canvas {
            margin: 0 auto;
            max-width: 600px;
            max-height: 500px;
            width: 100%;
            height: auto;
}

    </style>
</head>
<body style="margin-bottom: 50px;">
    <header style="text-align: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 10px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/banner2.png'))) }}" alt="Logo Izquierdo" style="width: auto; height: 100px;">
            <div style="text-align: center;">
                <h2 style="margin: 0;">Reporte de producción del Departamento de {{ auth()->user()->departamento->nombre }}</h2>
                <h2 style="margin: 5px 0 0;">{{ $filtroTexto }}</h2>
            </div>

            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/banner1.png'))) }}" alt="Logo Derecho" style="width: auto; height: 100px;">
        </div>
    </header>

    <h2 style="text-align: center;">Tabla de registros totales</h2>
    <table style="margin-bottom: 60px;">
    <thead>
        <tr>
            <th></th>
            <th>Autor</th>
            <th>Nombre</th>
            <th>Tipo de Registro</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $index => $registro)
            @if ($index == 8 || ($index > 8 && ($index - 8) % 12 == 0))
                </tbody>
            </table>

            <div style="page-break-before: always;"></div>

            <table style="margin-bottom: 60px;">
                <thead>
                    <tr>
                        <th></th>
                        <th>Autor</th>
                        <th>Nombre</th>
                        <th>Tipo de Registro</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
            @endif

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $registro->user_name }} {{ $registro->user_apellidos }}</td>
                <td>{{ $registro->nombre }}</td>
                <td>
                    @switch($registro->registrable_type)
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
                        @case('App\Models\Tesis')
                            Tesis
                        @break
                        @case('App\Models\Otro')
                            Otro
                        @break
                        @case('App\Models\Capitulom')
                            Capítulo de Memoria
                        @break
                        @default
                    @endswitch
                </td>
                <td style="width: 75px;">{{ $registro->created_at->format('d-M') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


    <div style="page-break-before: always; margin-bottom:50px;"></div>

    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 10px;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/banner2.png'))) }}" alt="Logo Izquierdo" style="width: auto; height: 100px;">
        <div style="text-align: center;">
            <h2 style="margin: 0;">Gráfico de Registros</h2>
        </div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/banner1.png'))) }}" alt="Logo Derecho" style="width: auto; height: 100px;">
    </div>
    <center><div style="width:600px; height:500px;">
        <img style="height: 500px; width: 600px;" src="{{ $chartUrl }}" alt="Gráfico de registros">
    </div></center>
    <!--<canvas id="chart" width="600" height="400"></canvas>-->
    <div class="footer" style="margin-bottom: 25px;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/footer.png'))) }}" alt="Footer Image" style="width: auto; height: 75px;">
    </div>
</body>
</html>
