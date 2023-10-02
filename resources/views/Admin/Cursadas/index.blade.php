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
    </div>
        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        
        <div class="table">
        <table class="table__body">
            <thead>
                <tr>
                    <th>Materia</td>
                    <th>Alumno</td>
                    <th>Estado</td>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            
            <tbody>
            @foreach ($cursadas as $cursada)
            <tr>
                <td>{{$textFormatService->ucfirst($cursada->asignatura)}}</td>
                <td>{{$textFormatService->ucfirst($cursada->alumno_apellido.' '.$cursada->alumno_nombre)}}</td>
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
                <td><a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id])}}"><button class="btn_edit">Editar</button></a></td>
                <td>
                   
                    <form method="POST" action="{{route('admin.cursadas.destroy', ['cursada' => $cursada->id])}}">
                        @csrf
                        @method('delete')
                        <input class="btn_borrar" type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $cursadas->appends(request()->query())->links('Componentes.pagination') }}
        </div>

    
    
@endsection
