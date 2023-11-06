@extends('Admin.template')

@section('content')

            <div class="contenedor-tabla_botonera">
            
                <form class="none grid lg-block form-hh" action="{{route('admin.alumnos.index')}}">
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
                                    <option value="ninguno">Ninguno</option>
                                    <option @selected($filtros['campo'] == 'egresados') value="egresados">Egresados</option>
                                    <option @selected($filtros['campo'] == 'registrados') value="registrados">Registrados</option>
                                </select>
                            </div>
                        </div>
        
                        <div class="contenedor_filtrado">
                            <input placeholder="Encontrar filtro..." class="filtrado-busqueda border-none p-1 shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                        </div>
                        
                        <div class="contenedor_btn-busqueda">
                            <input class="btn-buscador1 p-1 border-none pointer" type="submit" value="Buscar">
                        </div>
                    </div>
                </form>
            
                <a class="none lg-block" href="{{route('admin.alumnos.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
            </div>
        

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}

        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.alumnos.create')}}"><button class="nuevo_alumno"><i class="ti ti-circle-plus"></i>Agregar alumno</button></a>
            </div>
            <table class="table__body">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th class="uppercase">Dni</th>
                        <th>Email</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($alumnos as $alumno)
                <tr>
                    <td class="capitalize">{{$alumno->nombre}}</td>
                    <td class="capitalize">{{$alumno->apellido}}</td>
                    <td>{{$alumno->dniPuntos()}}</td>
                    <td>{{$alumno->email?$alumno->email:'Sin mail registrado'}}</td>
                    <td><a href="{{route('admin.alumnos.edit', ['alumno' => $alumno->id])}}">
                        <button class="btn_edit">Detalles</button>
                    </a></td>
                    {{-- <td>
                        <form method="POST" action="{{route('admin.alumnos.destroy', ['alumno' => $alumno->id])}}">
                            @csrf
                            @method('delete')
                            <input class="btn_borrar" type="submit" value="Eliminar">
                        </form>
                    </td> --}}
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        

        
        
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $alumnos->appends(request()->query())->links('Componentes.pagination') }}
        </div>


    
@endsection
