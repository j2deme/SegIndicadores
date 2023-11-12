<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sector;
use App\Models\Subsector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectores = [
            [
                'nombre' => 'Tecnologías de la Información y las Comunicaciones',
                'subsectores' => ['Bases de Datos', 'Computación', 'Desarrollo Web', 'Minería de Datos', 'Multimedia', 'Programación Aplicada a la Tecnología', 'Redes', 'Sistemas Computacionales', 'Software', 'Tecnologías de la Información para el Aprendizaje']
            ],
            [
                'nombre' => 'Pedagogía',
                'subsectores' => ['Educación', 'Enseñanza de las Matemáticas', 'Enseñanza de las Ciencias', 'Filosofía', 'Historia', 'Letras', 'Lingüística', 'Política Educativa']
            ],
            [
                'nombre' => 'Medio Ambiente',
                'subsectores' => ['Agua', 'Arquitectura Sostenible y Gestión Urbana', 'Bioprocesos', 'Desarrollo Forestal', 'Eficiencia Energética', 'Energías Renovables', 'Gestión Ambiental', 'Manejo de Zona Costera', 'Procesos Químicos', 'Suelo', 'Urbanismo']
            ],
            [
                'nombre' => 'Manufactura',
                'subsectores' => ['Aeronáutica', 'Automatización', 'Automotriz', 'Eléctrica', 'Electrónica', 'Industrial', 'Instrumentación Biomédica', 'Materiales', 'Mecánica', 'Mecatrónica', 'Metalurgia', 'Procesamiento de Señales', 'Química', 'Robótica']
            ],
            [
                'nombre' => 'Alimentos',
                'subsectores' => ['Acuacultura', 'Agricultura', 'Agropecuaria', 'Agrosistemas', 'Biología', 'Bioquímica', 'Biotecnología', 'Bioctecnología Microbiana', 'Irrigación', 'Pesquera', 'Producción Pecuaria']
            ],
            [
                'nombre' => 'Administración',
                'subsectores' => ['Administración', 'Administración Industrial', 'Ciencias Económicas', 'Ciencias Sociales', 'Contador Público', 'Contaduría', 'Derecho', 'Desarrollo Comunitario', 'Gestión Empresarial', 'Ingeniería Administrativa', 'Planeación Estratégica']
            ],
        ];

        foreach ($sectores as $s) {
            $sector         = new Sector();
            $sector->nombre = $s['nombre'];
            $sector->save();

            foreach ($s['subsectores'] as $sub) {
                $subsector         = new Subsector();
                $subsector->nombre = $sub;
                $subsector->sector()->associate($sector);
                $subsector->save();
            }
        }

        $this->command->info('Sectores y subsectores creados.');
    }
}
