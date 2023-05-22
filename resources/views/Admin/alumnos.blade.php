@extends('Admin.template')

@section('content')
    <div>
        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Dni</td>
                <td>Acciones</td>
            </tr>

            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{$alumno->nombre}}</td>
                <td>{{$alumno->apellido}}</td>
                <td>{{$alumno->dni}}</td>
                <td>editar</td>
            </tr>
            @endforeach

        </table>

        {{$alumnos -> links()}}
    </div>
@endsection