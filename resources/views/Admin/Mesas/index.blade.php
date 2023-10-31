@extends('Admin.template')

@section('content')
    
<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.mesas.create')}}"><button class="nuevo_alumno">Agregar mesa</button></a>
    
    <div class="contenedor-tabla_botonera">
        <form class="none grid lg-block form-hh" action="{{route('admin.mesas.index')}}">
            <div class="alumnos_filtrar gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'asignatura') value="asignatura">Asignatura</option>
                            <option @selected($filtros['orden'] == 'fecha') value="fecha">Fecha</option>
                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">Ninguno</option>
                            <option @selected($filtros['campo'] == 'proximas') value="proximas">Proximas</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor_filtrado">
                    <input placeholder="programacion : algebra" class="filtrado-busqueda border-none rounded p-1 bg-white shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div class="contenedor_btn-busqueda">
                    <input class="btn-buscador1 p-1 border-none rounded pointer" type="submit" value="Buscar">
                </div>
            </div>
        </form>
    
        
    
        <a class="none lg-block" href="{{route('admin.mesas.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
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
                    <th>Año</td>
                    <th>Materia</td>
                    <th>Llamado</th>
                    
                    <th>Fecha</td>
                    <th>Carrera</td>
                    <th colspan="2">Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                        <td class="center">{{$mesa->asignatura->anio}}</td>
                    <td>{{$mesa->asignatura->nombre}}</td>
                    <td class="center">
                        @if ($mesa->llamado == 1 || $mesa->llamado == 0)
                            Primero
                        @else
                            Segundo
                        @endif
                    </td>
                    
                    <td>{{$formatoFecha->dmahm($mesa->fecha)}}</td>
                    <td>{{$mesa->asignatura->carrera->nombre}}</td>
                    <td><a href="{{route('admin.mesas.edit', ['mesa' => $mesa->id])}}"><button class="btn_edit">Editar</button></a></td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $mesas->appends(request()->query())->links('Componentes.pagination') }}
        </div>


    
@endsection
