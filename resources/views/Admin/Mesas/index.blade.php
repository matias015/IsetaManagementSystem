@extends('Admin.template')

@section('content')
    
    <div class="contenedor-tabla_botonera">
        <form class="none grid lg-block form-hh" action="{{route('admin.mesas.index')}}">
            <div class="alumnos_filtrar gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none p-1 shadow" name="orden">
                            <option @selected($filtros['orden'] == 'fecha') value="fecha">Fecha</option>
                            <option @selected($filtros['orden'] == 'asignatura') value="asignatura">Asignatura</option>
                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none p-1 shadow" name="campo">
                            <option value="ninguno">Ninguno</option>
                            <option @selected($filtros['campo'] == 'proximas') value="proximas">Proximas</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor_filtrado">
                    <input placeholder="programacion : algebra" class="filtrado-busqueda border-none p-1 shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div class="contenedor_btn-busqueda">
                    <button class="btn_sky"><i class="ti ti-search"></i>Buscar</button>
                </div>
            </div>
        </form>
    
        
    
        <a class="none lg-block" href="{{route('admin.mesas.index')}}"><button class="btn_red"><i class="ti ti-backspace"></i>Quitar filtros</button></a>
    </div>


        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        
        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.mesas.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar mesa</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    <th>Año</th>
                    <th>Materia</th>
                    <th>Llamado</th>
                    <th class="center">Fecha</th>
                    <th>Carrera</th>
                    <th class="center">Acción</th>
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
                    <td><a href="{{route('admin.mesas.edit', ['mesa' => $mesa->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $mesas->appends(request()->query())->links('Componentes.pagination') }}
        </div>
@endsection
