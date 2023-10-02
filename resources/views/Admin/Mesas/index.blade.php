@extends('Admin.template')

@section('content')


        

    
<div class="bg-transparent contenedor_top flex items-end gap-2">

    <a href="{{route('admin.mesas.create')}}"><button class="p-1 nuevo_alumno">Agregar mesa</button></a>
    
    
        <form class="none grid lg-block form-hh" action="{{route('admin.mesas.index')}}">
            <div class="alumnos_filtrar gap-5 flex items-end">
                
                <div class="">
                    <p class="categoria">Ordenar</p>
                    <div>
                        <select class="border-none rounded p-1 bg-white shadow" name="orden">
                            <option @selected($filtros['orden'] == 'asignatura') value="asignatura">Asignatura</option>
                            <option @selected($filtros['orden'] == 'fecha') value="fecha">Fecha</option>

                        </select>
                    </div>
                </div>
                <div>
                    <p class="categoria">Mostrar</p> 

                    <div class="contenedor_filtrar">
                        <select class="border-none rounded p-1 bg-white shadow" name="campo">
                            <option value="ninguno">ninguno</option>
                            <option @selected($filtros['campo'] == 'proximas') value="proximas">Proximas</option>
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
    
        
    
    <a class="none lg-block" href="{{route('admin.mesas.index')}}"><button class="p-1 border-none red-800 font-600 white rounded pointer">Quitar filtros</button></a>

    
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
                    <th>Materia</td>
                    <th>Llamado</th>
                    <th>Año</td>
                    <th>Fecha</td>
                    <th>Carrera</td>
                    <th colspan="2">Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                    <td>{{$textFormatService->ucfirst($mesa->nombre)}}</td>
                    <td>
                        @if ($mesa->llamado == 1 || $mesa->llamado == 0)
                            1
                        @else
                            2
                        @endif
                    </td>
                    <td>{{$mesa->anio + 1}}</td>
                    <td>{{$mesa->fecha}}</td>
                    <td>{{$textFormatService->ucfirst($mesa->carrera)}}</td>
                    <td><a href="{{route('admin.mesas.edit', ['mesa' => $mesa->id])}}"><button class="btn_edit">editar</button></a></td>
                    <td>
                        <form method="POST" action="{{route('admin.mesas.destroy', ['mesa' => $mesa->id])}}">
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
            {{ $mesas->appends(request()->query())->links('Componentes.pagination') }}
        </div>


    
@endsection
