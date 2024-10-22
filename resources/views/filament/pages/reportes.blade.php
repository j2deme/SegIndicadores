<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<x-filament-panels::page>
    <div class="overflow-x-auto w-full">
        <a href="{{ route('reporte.pdf') }}" style="background-color: #4CAF50; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 8px;">
            Generar PDF
        </a>

    @livewire('list-registros')
    </div>
</x-filament-panels::page>
