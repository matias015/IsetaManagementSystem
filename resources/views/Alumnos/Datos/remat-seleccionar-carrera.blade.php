@extends('Alumnos.layout')
@section('content')

<main id="fondo-estudiantes">
    <section class="perfil">
   
        @if (!$en_fecha)
            <h1>No es fecha de rematriculacion</h1>
        @else
            <div class="black flex-col gap-3 p-3 w-100">
                @foreach ($carreras as $carrera)
                    <form class="grid-1 w-100" action="{{route('alumno.rematriculacion.asignaturas', ['carrera'=>$carrera->id])}}">
                        <input class="p-3 border-none bg-gray-100 shadow rounded-2 pointer" type="submit" value="{{$carrera->nombre}}">
                    </form>
                @endforeach
            </div>
        @endif

    </section>
  
</main>
@endsection
