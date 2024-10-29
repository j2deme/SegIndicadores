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
    <header>
        <div class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logoloro.jpg'))) }}" alt="logo" style="float: left; width: 90px; height: auto; margin-right: 10px;">
            <h2>Reporte de registros</h2>
        </div>
    </header>
    
    

    
        <h3 class="text-xl font-semibold">Gráfico de Registros</h3>
        <canvas id="chart" width="400" height="200"></canvas>
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
    
   
    
     <h2>Tabla de registros totales</h2>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Autores</th>
                <th >Nombre</th>
                <th>Tipo de Registro</th>
                <th>Fecha</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $index => $registro)
            <tr>
                <td>{{ $index + 1 }}</td> 
                    <td>{{ $registro->autores }}</td>
                    <td>{{ $registro->nombre }}</td>
                    <td>{{ $registro->registrable_type }}</td>
                     <td>{{ $registro->created_at->format('Y')  }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
