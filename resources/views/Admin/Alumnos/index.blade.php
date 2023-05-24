@extends('Admin.template')

@section('content')
    <div>
        <script src="https://cdn.tailwindcss.com"></script>

        <a href="{{route('alumnos.create')}}"><button class="m-2 text-blue-600">Agregar alumno</button></a>

        <div>
            <form action="{{route('alumnos.index')}}">
                <p>filtrar</p> 
                 <input class="m-2 bg-slate-400 rounded p-1" name="filtro" type="text">
                 <input class="m-2 text-blue-600" type="submit" value="Buscar">
            </form>

            <a class="m-2 text-blue-600" href="{{route('alumnos.index')}}"><button>Quitar filtro</button></a>
      
        </div>


        <table class="m-2">
            <tr>
                <td class="p-2">Nombre</td>
                <td class="p-2">Apellido</td>
                <td class="p-2">Dni</td>
                <td class="p-2">Acciones</td>
            </tr>

            @foreach ($alumnos as $alumno)
            <tr>
                <td class="p-2">{{$alumno->nombre}}</td>
                <td class="p-2">{{$alumno->apellido}}</td>
                <td class="p-2">{{$alumno->dni}}</td>
                <td class="p-2 text-blue-600"><a href="{{route('alumnos.edit', ['alumno' => $alumno->id])}}"><button>editar</button></a></td>
                <td class="p-2  text-red-600"><a href="{{route('alumnos.destroy', ['alumno' => $alumno->id])}}"></a><button>eliminar</button></td>
            </tr>
            @endforeach

        </table>

        {{ $alumnos->appends(request()->query())->links() }}
        
    </div>
@endsection