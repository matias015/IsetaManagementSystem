@extends('Admin.template')

@section('content')

<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.carreras.create')}}"><button class="p-1 nuevo_alumno">Agregar carrera</button></a>
    
    
        <form class="none grid lg-block form-hh" action="{{route('admin.carreras.index')}}">
            <div class="alumnos_filtrar gap-5 flex items-end">
                
                <div class="">
                    <p class="categoria">Ordenar</p>
                    <div>
                        <select class="border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                        </select>
                    </div>
                </div>
                <div>
                    <p class="categoria">Mostrar</p> 

                    <div class="contenedor_filtrar">
                        <select class="border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">Todas</option>
                            <option @selected($filtros['campo'] == 'vigentes') value="vigentes">Vigentes</option>
                        </select>
                    </div>
                </div>

                <div>
                    <p>Termino</p>
                    <input class="border-none rounded p-1 bg-white shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div>
                    <input class="p-1 border-none rounded pointer" type="submit" value="Buscar">
                </div>
            </div>
        </form>
    
        
    
    <a class="none lg-block" href="{{route('admin.carreras.index')}}"><button class="p-1 border-none red-800 font-600 white rounded pointer">Quitar filtros</button></a>

    
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
