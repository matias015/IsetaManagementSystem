<?php

namespace Tests\Feature;

use App\Models\Alumno;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AlumnoExamenesTest extends TestCase
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
 
         $response = $this->get('/alumno/examenes');
         $response->assertStatus(200)
             ->assertSee('Test_asignatura_1')
             ->assertSee('Test_asignatura_2')
             ->assertSee('No hay datos de mesa')
             ->assertSee('8.00')
             ->assertSee('6.00')
             ->assertSee('Aun no rendido');
     }
}
