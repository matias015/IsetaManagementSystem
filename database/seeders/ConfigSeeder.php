<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuracion::create([
            'key' => 'dias_habiles_inscripcion',
            'value' => 2
        ]);

        Configuracion::create([
            'key' => 'dias_habiles_desinscripcion',
            'value' => 1
        ]);



    }
}
