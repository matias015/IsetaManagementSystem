@extends('Alumnos.layout')
@section('content')

<main id="fondo-estudiantes">
    <section class="table">
   
        @if (!$en_fecha)
                <div class="table__header">
                    <h1>No es fecha de rematriculacion</h1>
                </div>
        @else
                <div class="table__header">
                    <h1>Rematriculación</h1>
                </div>

                <div class="black flex-col  w-100 gap-3 p-3 ">
                @foreach ($carreras as $carrera)
                    <form class="grid-1 w-100" action="{{route('alumno.rematriculacion.asignaturas', ['carrera'=>$carrera->id])}}">
                        <input class="p-3 border-none bg-gray-100 shadow rounded-2 pointer style_hover" type="submit" value="{{$carrera->nombre}}">
                    </form>
                @endforeach
                </div>
        @endif

    </section>
  
</main>
@endsection
