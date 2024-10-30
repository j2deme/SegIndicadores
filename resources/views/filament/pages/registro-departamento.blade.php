<x-filament-panels::page>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <div class="flex justify-between">
        <div>
            <label for="filtroPeriodo" class="mr-2">Seleccionar periodo:</label>
            <select wire:model="filter" id="filtroPeriodo" class="border rounded px-2 py-1" style="width: 130px;">
                <option value="anual">Anual</option>
                <option value="semestre">Semestral</option>
                <option value="trimestre">Trimestral</option>
            </select>
        </div>

        <x-filament::button wire:click="generadorPDF">Generar Reporte</x-filament::button>
    </div>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div style="width: 80%; margin-left:90px; padding:40px;" >
                    @livewire('conteodepartamental')
                </div>
            </div>
            <div class="swiper-slide">
                <div style="width: 80%; margin-left:90px; padding:40px;" >
                    @livewire('conteodepartamental2')
                </div>
            </div>
            <div class="swiper-slide">
                <div style="width: 80%; margin-left:90px; padding:40px;" >
                    @livewire('conteodepartamental3')
                </div>
            </div>
            <div class="swiper-slide">
                <div style="width: 80%; margin-left:90px; padding:40px;" >
                    @livewire('conteodepartamental4')
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>

    </div>
    <div class="swiper-container2">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="width: 75%;">
                <div style="width: 90%; float:left; height: 200px; margin-left: 5%;">
                    @livewire('producciondepartamentomeses')
                </div>
            </div>
            <div class="swiper-slide" style="width: 75%;">
                <div style="width: 90%; height: 230px; float:right; margin-left: 1%; margin-right: 4%;">
                    @livewire('estadisticachart')
                </div>
            </div>
            <div class="swiper-slide" style="width: 75%;">
                <div style="width: 90%; float:left; height: 230px; margin-left: 5%;">
                    @livewire('producciondepartamento')
                </div>
            </div>
            <div class="swiper-slide" style="width: 75%;">
                <div style="width: 90%; float:right; margin-left: 1%; margin-right: 4%;">
                    @livewire('producciondepartamentodocentes')
                </div>
            </div>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div><br><br>
        <div class="swiper-pagination"></div>
    </div>

    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        var swiper2 = new Swiper('.swiper-container2', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

        <style>
            .swiper-container {
                overflow: hidden;
                position: relative;
            }
            .swiper-container2 {
                overflow: hidden;
                position: relative;
            }
        </style>
</x-filament-panels::page>
