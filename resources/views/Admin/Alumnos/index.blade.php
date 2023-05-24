@extends('Admin.template')

@section('content')

    <div>
        <script src="https://cdn.tailwindcss.com"></script>

    
            <a href="{{route('alumnos.create')}}"><button>Agregar alumno</button></a>

        <div>
            <form action="{{route('alumnos.index')}}">
                <p>filtrar</p> 
                 <input  name="filtro" type="text">
                 <input type="submit" value="Buscar">
            </form>

            <a href="{{route('alumnos.index')}}"><button>Quitar filtro</button></a>
      
        </div>

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        

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
                <td><a href="{{route('alumnos.edit', ['alumno' => $alumno->id])}}"><button>editar</button></a></td>
                <td><a href="{{route('alumnos.destroy', ['alumno' => $alumno->id])}}"></a><button>eliminar</button></td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $alumnos->appends(request()->query())->links() }}
        </div>

    </div>
    
@endsection