<?php

namespace App\Repositories;

use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Examen;

class AlumnoMatriculacionRepository
{
    public $config;

    public function __construct() {
        $this->config = Configuracion::todas();
    }

}