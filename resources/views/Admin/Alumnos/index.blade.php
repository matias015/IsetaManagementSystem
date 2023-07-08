@extends('Admin.template')

@section('content')

    
        <div class="contenedor_top">
            <a href="{{route('admin.alumnos.create')}}"><button class="nuevo_alumno">Agregar alumno</button></a>
            
            
                <form class="form-hh" action="{{route('admin.alumnos.index')}}">
                    <div class="alumnos_filtrar">
                        <p class="categoria">filtrar</p> 
                        <div>
                            <select name="campo">
                                <option value="ninguno">ninguno</option>
                                <option @selected($filtros['campo'] == 'nombre-apellido') value="nombre-apellido">nombre/apellido</option>
                                <option @selected($filtros['campo'] == 'dni') value="dni">dni</option>
                                <option @selected($filtros['campo'] == 'email') value="email">email</option>
                                <option @selected($filtros['campo'] == 'cursando') value="cursando">cursando</option>
                                <option @selected($filtros['campo'] == 'registrados') value="registrados">registrados</option>
                            </select>
                        </div>
        
                        <div>
                            <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                        </div>
                        <p class="categoria">ordenar</p>
                        <div>
                            <select name="orden">
                                <option @selected($filtros['orden'] == 'nombre') value="nombre">nombre</option>
                                <option @selected($filtros['orden'] == 'dni') value="dni">dni</option>
                                <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">dni descendiente</option>

                            </select>
                        </div>

                        <div>
                            <input class="buscar_filtro" type="submit" value="Buscar">
                        </div>
                    </div>
                </form>
            
                
            
            <a href="{{route('admin.alumnos.index')}}"><button class="quitar_filtro">Quitar filtro</button></a>

            
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
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->apellido)}}</td>
                <td>{{$alumno->dni}}</td>
                <td><a href="{{route('admin.alumnos.edit', ['alumno' => $alumno->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.alumnos.destroy', ['alumno' => $alumno->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
            
            

        </table>
        </div>
        

        
        
        <div class="w-1/2 mx-auto p-5">
            {{ $alumnos->appends(request()->query())->links('Comp.pagination') }}
        </div>


    
@endsection
