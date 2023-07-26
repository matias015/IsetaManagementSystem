@extends('Alumnos.layout')
@section('content')

<main id="fondo-estudiantes">
    <section class="perfil">
   
        @if (!$en_fecha)
            <h1>No es fecha de rematriculacion</h1>
        @else
            <div class="black">
                @foreach ($carreras as $carrera)
                    <form action="{{route('alumno.rematriculacion.asignaturas', ['carrera'=>$carrera->id])}}">
                        <input type="submit" value="{{$carrera->nombre}}">
                    </form>
                @endforeach
            </div>
        @endif

    </section>
  
</main>
@endsection
