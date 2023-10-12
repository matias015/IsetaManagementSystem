@extends('Admin.template')

@section('content')

<div class="contenedor_top bg-transparent flex items-end gap-2">

    <a href="{{route('admin.carreras.create')}}"><button class="nuevo_alumno">Agregar carrera</button></a>
    
    <div class="contenedor-tabla_botonera">
        <form class="none grid lg-block form-hh" action="{{route('admin.carreras.index')}}">
            <div class="tabla_botonera gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">Todas</option>
                            <option @selected($filtros['campo'] == 'vigentes') value="vigentes">Vigentes</option>
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
    
        <a class="none lg-block" href="{{route('admin.carreras.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
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
                <th>Carrera</td>
                <th>Resolucion</td>
                <th>Apertura</td>
                <th>Fin</td>
                <th>Observaciones</td>
                <th colspan="2">Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($carreras as $carrera)
            <tr>
                <td>{{$textFormatService->ucfirst($carrera->nombre)}}</td>
                <td>{{$carrera->resolucion}}</td>
                <td>{{$carrera->anio_apertura}}</td>
                <td>{{$carrera->anio_fin == 0? "Aun vigente":$carrera->anio_fin}}</td>
                <td>{{$carrera->observaciones}}</td>
                <td><a href="{{route('admin.carreras.edit', ['carrera' => $carrera->id])}}"><button class="btn_edit">editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.carreras.destroy', ['carrera' => $carrera->id])}}">
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
        {{ $carreras->appends(request()->query())->links('Componentes.pagination') }}
    </div>


@endsection
