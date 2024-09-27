<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Capitulol;
use App\Models\Registro;
use App\Models\Capitulom;
use App\Models\libro;


class RegistroSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i <6; $i++) {
            $capitulo = Capitulol::create([
                'libro' => $faker->sentence(20),
                'pagina_inicio' => $faker->numberBetween(1, 20),
                'pagina_fin' => $faker->numberBetween(21, 50),
                'isbn' => $faker->isbn13(),
                'issn' => null,
                'casa_editorial' => $faker->company(),
                'edicion' => $faker->numberBetween(1, 5),
                'user_id' => $faker->numberBetween(2, 7), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
            Registro::create([
                'nombre' => $capitulo->libro,
                'proposito' => $faker->sentence(),
                'autores' => $faker->name(),
                'posicion_autor' => 1,
                'descripcion' => $faker->paragraph(),
                'sector_id' => $faker->numberBetween(1, 6),
                'subsector_id' => $faker->numberBetween(1, 25),
                'area_prioritaria_pais' => $faker->word(),
                'area_conocimiento' => $faker->word(),
                'fecha_publicacion' => $faker->date(),
                'pais_publicacion' => $faker->country(),
                'evidencia' => 'archivo.pdf',
                'user_id' => $capitulo->user_id,
                'registrable_id' => $capitulo->id,
                'registrable_type' => Capitulo::class,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $historias = Capitulom::create([
                'congreso' => $faker->sentence(20),
                'estado_region'=> $faker->name(20),
                'ciudad'=>$faker->country(),
                'revision'=>$faker->sentence(20),
                'pagina_inicio'=>$faker->numberBetween(1, 20),
                'pagina_fin'=> $faker->numberBetween(21, 50),
                'isbn'=>$faker->isbn13(),
                'issn'=> null,
                'user_id' => $faker->numberBetween(2, 7),
            ]);

            
            Registro::create([
                'nombre' => $historias->congreso,
                'proposito' => $faker->sentence(),
                'autores' => $faker->name(),
                'posicion_autor' => 1,
                'descripcion' => $faker->paragraph(),
                'sector_id' => $faker->numberBetween(1, 6),
                'subsector_id' => $faker->numberBetween(1, 25),
                'area_prioritaria_pais' => $faker->word(),
                'area_conocimiento' => $faker->word(),
                'fecha_publicacion' => $faker->date(),
                'pais_publicacion' => $faker->country(),
                'evidencia' => 'archivo.pdf',
                'user_id' => $historias->user_id,
                'registrable_id' => $historias->id,
                'registrable_type' =>Historias::class,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $Libros = Libro::create([
                'tipo_participacion_autor'=> $faker->sentence(20),
                'paginas' => $faker->numberBetween(1, 20),
                'isbn'=>$faker->isbn13(),
                'issn'=> null,
                'casa_editorial'=> $faker->company(),
                'edicion'=> $faker->numberBetween(1, 5),
                'user_id'=> $faker->numberBetween(2, 7),
                
            ]);

            
            Registro::create([
                'nombre' => $Libros->tipo_participacion_autor,
                'proposito' => $faker->sentence(),
                'autores' => $faker->name(),
                'posicion_autor' => 1,
                'descripcion' => $faker->paragraph(),
                'sector_id' => $faker->numberBetween(1, 6),
                'subsector_id' => $faker->numberBetween(1, 25),
                'area_prioritaria_pais' => $faker->word(),
                'area_conocimiento' => $faker->word(),
                'fecha_publicacion' => $faker->date(),
                'pais_publicacion' => $faker->country(),
                'evidencia' => 'archivo.pdf',
                'user_id' => $Libros->user_id,
                'registrable_id' => $Libros->id,
                'registrable_type' =>Libros::class,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}

