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
            'key' => 'filas_por_tabla',
            'value' => 25
        ]);
        
        Configuracion::create([
            'key' => 'horas_habiles_inscripcion',
            'value' => 48
        ]);

        Configuracion::create([
            'key' => 'horas_habiles_desinscripcion',
            'value' => 24
        ]);
        
        Configuracion::create([
            'key' => 'fecha_inicial_rematriculacion',
            'value' => 24
        ]);
        Configuracion::create([
            'key' => 'fecha_final_rematriculacion',
            'value' => 24
        ]);

    }
}
