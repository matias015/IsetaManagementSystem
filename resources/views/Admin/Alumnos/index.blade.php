@extends('Admin.template')

@section('content')
    <div>
        <script src="https://cdn.tailwindcss.com"></script>

        <a href="{{route('alumnos.create')}}"><button>nuevo</button></a>
        
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