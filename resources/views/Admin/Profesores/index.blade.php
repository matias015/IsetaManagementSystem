@extends('Admin.template')

@section('content')

<div class="contenedor_top bg-transparent flex items-end gap-2">

    <a href="{{route('admin.profesores.create')}}"><button class="nuevo_alumno">Agregar profesor</button></a>
    
    <div class="contenedor-tabla_botonera">

        <form class="none grid lg-block form-hh" action="{{route('admin.profesores.index')}}">
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
                            <option value="ninguno">Ninguno</option>
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
    
        
    
    <a class="none lg-block" href="{{route('admin.profesores.index')}}"><button class="quitar_filtro">Quitar filtros</button></a>
    </div>
    
</div>  

        {{-- @foreach ($profesores->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $profesores->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        
        <div class="table">
        <table class="table__body">
            <thead>
                <tr>
                    <th>Nombre</td>
                    <th>Apellido</td>
                    <th>DNI</td>
                    <th class="center">Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                <tr>
                    <td>{{$profesor->nombre}}</td>
                    <td>{{($profesor->apellido)}}</td>
                    <td>{{$profesor->dni}}</td>
                    <td class="center"><a class="flex just-center" href="{{route('admin.profesores.edit', ['profesor' => $profesor->id])}}"><button class="btn_edit">Ver</button></a></td>
                    {{--
                    <td>
                         <form method="POST" action="{{route('admin.profesores.destroy', ['profesor' => $profesor->id])}}">
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
            {{ $profesores->appends(request()->query())->links('Componentes.pagination') }}
        </div>

    
    
@endsection
