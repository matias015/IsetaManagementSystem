@extends('Admin.template')

@section('content')


<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.egresados.create')}}"><button class="nuevo_alumno">Agregar inscripcion</button></a>
    
    <div class="contenedor-tabla_botonera">

        <form class="none grid lg-block form-hh" action="{{route('admin.egresados.index')}}">

            <div class="tabla_botonera gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                            <option @selected($filtros['orden'] == 'dni') value="dni">DNI</option>
                            <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">DNI descendiente</option>

                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">Todos</option>
                            <option @selected($filtros['campo'] == 'egresados') value="egresados">Egresados</option>
                            <option @selected($filtros['campo'] == 'registrados') value="registrados">Registrados</option>
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
    
        <a class="none lg-block" href="{{route('admin.egresados.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
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
                    <th>Apellido y nombre</th>
                    {{-- <th>Dni</th> --}}
                    <th>Carrera</th>
                    <th>Periodo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>
                    {{$textFormatService->ucwords($alumno->apellido.' '. $alumno->nombre)}}
                </td>
                
                {{-- <td>{{$alumno->dni}}</td> --}}
                <td>{{$textFormatService->ucfirst($alumno->carrera)}}</td>
                <td>
                    {{$alumno->anio_inscripcion?$alumno->anio_inscripcion:'Sin datos'}}
                    -
                    {{$alumno->anio_finalizacion? $alumno->anio_finalizacion:'Presente'}}
                </td>
                
                <td><a href="{{route('admin.egresados.edit', ['egresado' => $alumno->id])}}"><button class="btn_edit">Ver</button></a>
                
                    <form method="POST" action="{{route('admin.egresados.destroy', ['egresado' => $alumno->id])}}">
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
            {{ $alumnos->appends(request()->query())->links('Componentes.pagination') }}
        </div>


    
@endsection
