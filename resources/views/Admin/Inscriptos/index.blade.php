@extends('Admin.template')

@section('content')
    
    <div class="contenedor-tabla_botonera">

        <form class="none grid lg-block form-hh" action="{{route('admin.inscriptos.index')}}">

            <div class="tabla_botonera gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none p-1 shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                            <option @selected($filtros['orden'] == 'dni') value="dni">DNI</option>
                            <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">DNI descendiente</option>

                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none p-1 shadow" name="campo">
                            <option value="ninguno">Todos</option>
                            <option @selected($filtros['campo'] == 'egresados') value="egresados">Egresados</option>
                            <option @selected($filtros['campo'] == 'registrados') value="registrados">Registrados</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor_filtrado">
                    <input placeholder="Encontrar filtro..." class="filtrado-busqueda border-none p-1 shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div class="contenedor_btn-busqueda">
                    <button class="btn_sky"><i class="ti ti-search"></i>Buscar</button>
                </div>
            </div>
        </form>
    
        <a class="none lg-block" href="{{route('admin.inscriptos.index')}}"><button class="btn_red"><i class="ti ti-backspace"></i>Quitar filtros</button></a>
    </div>


        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}

        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.inscriptos.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar inscripcion</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    <th>Apellido y nombre</th>
                    {{-- <th>Dni</th> --}}
                    <th>Carrera</th>
                    <th>Periodo</th>
                    <th class="center">Acción</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>
                    {{$alumno->apellido.' '. $alumno->nombre}}
                </td>
                
                {{-- <td>{{$alumno->dni}}</td> --}}
                <td>{{$alumno->carrera}}</td>
                <td>
                    {{$alumno->anio_inscripcion?$alumno->anio_inscripcion:'Sin datos'}}
                    -
                    {{$alumno->anio_finalizacion? $alumno->anio_finalizacion:'Presente'}}
                </td>
                
                <td class="flex just-center"><a href="{{route('admin.inscriptos.edit', ['inscripto' => $alumno->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                
            </tr>
            @endforeach
            </tbody>
            
            

        </table>
        </div>
        

        
        
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $alumnos->appends(request()->query())->links('Componentes.pagination') }}
        </div>    
@endsection
