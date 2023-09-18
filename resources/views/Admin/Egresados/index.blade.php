@extends('Admin.template')

@section('content')


<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.egresados.create')}}"><button class="p-1 nuevo_alumno">Agregar alumno</button></a>
    
    
        <form class="none grid lg-block form-hh" action="{{route('admin.egresados.index')}}">
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
                    <p>Buscar</p>
                    <input placeholder="Dni, Apellido, Nombre, mail" class="border-none rounded p-1 bg-white shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div>
                    <input class="p-1 border-none rounded pointer" type="submit" value="Buscar">
                </div>
            </div>
        </form>
    
        
    
    <a class="none lg-block" href="{{route('admin.egresados.index')}}"><button class="p-1 border-none red-800 font-600 white rounded pointer">Quitar filtros</button></a>

    
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
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dni</th>
                    <th>Carrera</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->apellido)}}</td>
                <td>{{$alumno->dni}}</td>
                <td>{{$textFormatService->utf8minusculas($alumno->carrera)}}</td>

                <td><a href="{{route('admin.alumnos.edit', ['alumno' => $alumno->id])}}"><button class="btn_edit">Ver</button></a></td>
                <td>
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
