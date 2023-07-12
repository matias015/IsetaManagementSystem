@extends('Admin.template')

@section('content')
    
    <div>
        

    
            <a href="{{route('admin.cursadas.create')}}"><button>Agregar cursada</button></a>

        <div>
            <form action="{{route('admin.cursadas.index')}}">
                <p>filtrar</p> 
                <select name="campo">
                    <option value="ninguno">todo</option>
                    <option @selected($filtros['campo'] == 'nuevas') value="nuevas">nuevas</option>
                    <option @selected($filtros['campo'] == 'asignatura') value="asignatura">asigantura</option>
                    <option @selected($filtros['campo'] == 'carrera') value="carrera">carrera</option>
                </select>
                <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                <p>ordenar</p>
                <select name="orden">
                    <option @selected($filtros['orden'] == 'creacion') value="creacion">Creacion</option>
                    <option @selected($filtros['orden'] == 'fecha') value="fecha">Fecha</option>
                    <option @selected($filtros['orden'] == 'asignatura') value="asignatura">asigantura</option>
                </select>
                <input type="submit" value="Buscar">
            </form>

            <a href="{{route('admin.cursadas.index')}}"><button>Quitar filtro</button></a>
      
        </div>

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        
        
        <table>
            <tr>
                <td>cursada</td>
                <td>materia</td>
                <td>alumno</td>
                <td>aprobada</td>
            </tr>

            @foreach ($cursadas as $cursada)
            <tr>
                <td>{{$cursada->id}}</td>
                <td>{{$cursada->asignatura}}</td>
                <td>{{$cursada->alumno}}</td>
                <td>
                    @switch($cursada->aprobada)
                        @case(1)
                            Aprobada
                            @break
                        @case(2)
                            Desaprobada
                            @break
                        @default
                            Cursando...
                    @endswitch
                </td>
                <td><a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id])}}"><button>editar</button></a></td>
                <td>
                   
                    <form method="POST" action="{{route('admin.cursadas.destroy', ['cursada' => $cursada->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $cursadas->appends(request()->query())->links('Componentes.pagination') }}
        </div>

    </div>
    
@endsection