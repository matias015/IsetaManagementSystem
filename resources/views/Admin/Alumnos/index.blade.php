@extends('Admin.template')

@section('content')

    <div>
        

    
            <a href="{{route('admin.alumnos.create')}}"><button>Agregar alumno</button></a>

        <div>
            <form action="{{route('admin.alumnos.index')}}">
                <p>filtrar</p>
                    <select name="campo">
                        <option @selected($filtros['campo'] == 'principales') value="principales">Principales</option>
                        <option @selected($filtros['campo'] == 'dni') value="dni">Dni</option>
                        <option @selected($filtros['campo'] == 'nombre') value="nombre">Nombre</option> 
                        <option @selected($filtros['campo'] == 'apellido') value="apellido">Apellido</option>   
                        <option @selected($filtros['campo'] == 'email') value="email">Email</option> 
                        <option @selected($filtros['campo'] == 'telefonos') value="telefonos">Telefonos</option>
                        <option @selected($filtros['campo'] == 'ciudad') value="ciudad">Ciudad</option>
                    </select> 
                 <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                 <input type="submit" value="Buscar">
            </form>

            <a href="{{route('admin.alumnos.index')}}"><button>Quitar filtro</button></a>
      
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
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->apellido)}}</td>
                <td>{{$alumno->dni}}</td>
                <td><a href="{{route('admin.alumnos.edit', ['alumno' => $alumno->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.alumnos.destroy', ['alumno' => $alumno->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $alumnos->appends(request()->query())->links('Comp.pagination') }}
        </div>

    </div>
    
@endsection