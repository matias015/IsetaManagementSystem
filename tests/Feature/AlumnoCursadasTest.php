<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AlumnoCursadasTest extends TestCase
{



    /**
     * [1,1], // Regular Aprobado
     * [1,2], // Regular DesAprobado
     * [1,3], // Regular Cursando
     * [0,1], // Libre
     * [2,1], // Promocion
     * [3,1], // Equivalencia
     */
    
    public function test_informacion_mostrada_es_correcta(): void
    {
        Auth::guard('web')->login(Alumno::where('email','test@gmail.com')->first());

        $response = $this->get('/alumno/cursadas');
        $response->assertStatus(200)
            ->assertSee('Test_asignatura_1')
            ->assertSee('Test_asignatura_3')
            ->assertSee('Test_asignatura_mismo_anio_3')
            ->assertSee('Test_asignatura_7')
            ->assertSee('Reprobada')
            ->assertSee('Cursando')
            ->assertSee('Libre')
            ->assertSee('Regular')
            ->assertSee('Promocion')
            ->assertSee('Equivalencia')
            ->assertSee('Año: 1')
            ->assertSee('Año: 7')
            ->assertSee('Si (8.00)')
            ->assertSee('Si (6.00)')
            ->assertSee('Aun sin aprobar');
    }

}
