@extends('Admin.template')

@section('content')

    <div>
        

    
            <a href="{{route('admin.profesores.create')}}"><button>Agregar profesor</button></a>

        <div>
            <form action="{{route('admin.profesores.index')}}">
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

            <a href="{{route('admin.profesores.index')}}"><button>Quitar filtro</button></a>
      
        </div>

        

        {{-- @foreach ($profesores->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $profesores->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        

        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Dni</td>
                <td>Acciones</td>
            </tr>

            @foreach ($profesores as $profesor)
            <tr>
                <td>{{$textFormatService->utf8UpperCamelCase($profesor->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($profesor->apellido)}}</td>
                <td>{{$profesor->dni}}</td>
                <td><a href="{{route('admin.profesores.edit', ['profesor' => $profesor->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.profesores.destroy', ['profesor' => $profesor->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $profesores->appends(request()->query())->links('Comp.pagination') }}
        </div>

    </div>
    
@endsection