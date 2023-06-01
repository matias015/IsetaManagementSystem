@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.carreras.update', ['carrera'=>$carrera->id])}}">
        @csrf
        @method('put')

        <p>carrera <input value="{{$carrera->nombre}}" name="nombre"></p>
        <p>resolucion <input value="{{$carrera->resolucion}}" name="resolucion"></p>
        <p>anio_apertura <input value="{{$carrera->anio_apertura}}" name="anio_apertura"></p>
        <p>anio_fin <input value="{{$carrera->anio_fin}}" name="anio_fin"></p>
        <p>observaciones <input value="{{$carrera->observaciones}}" name="observaciones"></p>

        <input type="submit" value="Actualizar">
       </form>
       <hr>
       <table>
        <tr>
            <td>año</td>
            <td>materia</td>
            <td>carga anual o semanal</td>
            <td>acciones</td>
        </tr>

        @foreach ($carrera->asignaturas as $asignatura)
            <tr>
                <td> {{$asignatura->anio + 1}} </td>

                <td> {{$asignatura->nombre}} </td>

                <td> {{$asignatura->carga_horaria}} horas</td>

                <td style="display:flex;">
                    <form action="">
                        <button>Editar</button>
                    </form>
                    <form action="">
                        <button>Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        
            

       </table>
    </div>


@endsection