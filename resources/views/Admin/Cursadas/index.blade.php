@extends('Admin.template')

@section('content')
    
    <div class="contenedor_top bg-transparent flex items-end gap-2">
        
        <a href="{{route('admin.cursadas.create')}}"><button class="nuevo_alumno">Agregar cursada</button></a>

        <div class="contenedor-tabla_botonera">

            <form class="none grid lg-block form-hh" action="{{route('admin.cursadas.index')}}">
                <div class="tabla_botonera gap-5 flex items-end">
                    <div class="contenedor_ordenar">
                        <span class="categoria">Ordenar</span>     
                        <div>
                            <select class="ordenar border-none rounded p-1 bg-white shadow" name="orden">
                                <option @selected($filtros['orden'] == 'creacion') value="creacion">Creacion</option>
                                <option @selected($filtros['orden'] == 'fecha') value="fecha">Fecha</option>
                                <option @selected($filtros['orden'] == 'asignatura') value="asignatura">Asigantura</option>
                            </select>
                        </div>
                    </div>

                    <div class="contenedor_filtrar">
                        <span class="categoria">Mostrar</span> 
                        <div>
                            <select class="filtrar border-none rounded p-1 bg-white shadow" name="campo">
                                <option value="ninguno">Todos</option>
                                <option @selected($filtros['campo'] == 'nuevas') value="nuevas">Nuevas</option>
                                <option @selected($filtros['campo'] == 'asignatura') value="asignatura">Asigantura</option>
                                <option @selected($filtros['campo'] == 'carrera') value="carrera">Carrera</option>
                            </select>
                        </div>
                    </div>

                    <div class="contenedor_filtrado">
                        <input placeholder="Encontrar filtro..." class="filtrado-busqueda border-none rounded p-1 bg-white shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                    </div>

                    <div class="contenedor_btn-busqueda">
                        <input class="btn-buscador1 p-1 border-none rounded pointer" type="submit" value="Buscar">
                    </div>
                </div>
            </form>

            <a href="{{route('admin.cursadas.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
      
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
                    <th>Alumno/a</td>
                    <th>Estado</td>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            
            <tbody>
            @foreach ($cursadas as $cursada)
            <tr>
                <td>{{$cursada->asignatura}}</td>
                <td>{{$cursada->alumno_apellido.' '.$cursada->alumno_nombre}}</td>
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
