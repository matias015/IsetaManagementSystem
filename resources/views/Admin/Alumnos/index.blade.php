@extends('Admin.template')

@section('content')

    <div>
        <div class="hhh">
            <a href="{{route('admin.alumnos.create')}}"><button>Agregar alumno</button></a>
            
                <form class="form-hh" action="{{route('admin.alumnos.index')}}">
                    <br>
                    <p>filtrar</p> 
                    <select name="campo">
                        <option value="ninguno">ninguno</option>
                        <option @selected($filtros['campo'] == 'nombre-apellido') value="nombre-apellido">nombre/apellido</option>
                        <option @selected($filtros['campo'] == 'dni') value="dni">dni</option>
                        <option @selected($filtros['campo'] == 'email') value="email">email</option>
                        <option @selected($filtros['campo'] == 'cursando') value="cursando">cursando</option>
                        <option @selected($filtros['campo'] == 'registrados') value="registrados">registrados</option>
                    </select>
        
                        <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                    <p>ordenar</p>
                    <select name="orden">
                        <option @selected($filtros['orden'] == 'nombre') value="nombre">nombre</option>
                        <option @selected($filtros['orden'] == 'dni') value="dni">dni</option>
                        <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">dni descendiente</option>

                    </select>
                    <br><br>
                    <input type="submit" value="Buscar">
                </form>
            <br>
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
