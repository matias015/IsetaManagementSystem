@extends('Admin.template')

@section('content')

<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.profesores.create')}}"><button class="p-1 nuevo_alumno">Agregar profesor</button></a>
    
    
        <form class="none grid lg-block form-hh" action="{{route('admin.profesores.index')}}">
            <div class="alumnos_filtrar gap-5 flex items-end">
                
                <div class="">
                    <p class="categoria">Ordenar</p>
                    <div>
                        <select class="border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">nombre</option>
                            <option @selected($filtros['orden'] == 'dni') value="dni">dni</option>
                            <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">dni descendiente</option>

                        </select>
                    </div>
                </div>
                <div>
                    <p class="categoria">Mostrar</p> 

                    <div class="contenedor_filtrar">
                        <select class="border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">ninguno</option>
                            <option @selected($filtros['campo'] == 'registrados') value="registrados">registrados</option>
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
    
        
    
    <a class="none lg-block" href="{{route('admin.profesores.index')}}"><button class="p-1 border-none red-800 font-600 white rounded pointer">Quitar filtros</button></a>

    
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
                    <th>Dni</td>
                    <th colspan="2">Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                <tr>
                    <td>{{$textFormatService->utf8UpperCamelCase($profesor->nombre)}}</td>
                    <td>{{$textFormatService->utf8UpperCamelCase($profesor->apellido)}}</td>
                    <td>{{$profesor->dni}}</td>
                    <td><a href="{{route('admin.profesores.edit', ['profesor' => $profesor->id])}}"><button class="btn_edit">Editar</button></a></td>
                    <td>
                        <form method="POST" action="{{route('admin.profesores.destroy', ['profesor' => $profesor->id])}}">
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
            {{ $profesores->appends(request()->query())->links('Componentes.pagination') }}
        </div>

    
    
@endsection
