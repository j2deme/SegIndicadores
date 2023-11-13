<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = ['Ciencias Básicas', 'Ciencias Económico Administrativas', 'Industrial', 'Ingenierías', 'Agronomía', 'Sistemas y Computación'];

        foreach ($departamentos as $departamento) {
            \App\Models\Departamento::create([
                'nombre' => $departamento,
            ]);
        }

        $this->command->info('Departamentos creados.');
    }
}
