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
            'value' => "2020-01-01 00:00:00"
        ]);
        Configuracion::create([
            'key' => 'fecha_final_rematriculacion',
            'value' => "2020-01-01 00:00:00"
        ]);
        Configuracion::create([
            'key' => 'anio_remat',
            'value' => "2024"
        ]);
        Configuracion::create([
            'key' => 'fecha_limite_desrematriculacion',
            'value' => "2020-01-01 00:00:00"
        ]);
        Configuracion::create([
            'key' => 'diferencia_llamados',
            'value' => "30"
        ]);
        Configuracion::create([
            'key' => 'anio_ciclo_actual',
            'value' => "2023"
        ]);

    }
}
