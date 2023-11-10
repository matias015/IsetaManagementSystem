@extends('Admin.template')

@section('content')

    <div class="contenedor-tabla_botonera">
        <form class="none grid lg-block form-hh" action="{{route('admin.carreras.index')}}">
            <div class="tabla_botonera gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none  p-1 shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none p-1 shadow" name="campo">
                            <option value="">Vigentes</option>
                            <option @selected($filtros['campo'] == 'todas') value="ninguno">Todas</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor_filtrado">
                    <input placeholder="Encontrar filtro..." class="filtrado-busqueda border-none p-1 bg-white shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div class="contenedor_btn-busqueda">
                    <input class="btn-buscador1 p-1 border-none pointer" type="submit" value="Buscar">
                </div>
            </div>
        </form>
    
        <a class="none lg-block" href="{{route('admin.carreras.index')}}"><button class="btn_red"><i class="ti ti-backspace"></i>Quitar filtros</button></a>
    </div>
    

    
    <div class="table">
        <div class="perfil__header-alt">
            <a href="{{route('admin.carreras.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar carrera</button></a>
        </div>
    <table class="table__body">
        <thead>
            <tr>
                <th>Carrera</td>
                {{--<th class="center">Resolución</th>--}}
                <th class="center">Apertura</th>
                <th class="center">Estado</th>
                <th class="center">Acción</th>
                <th class="center">Cargar</th>
                <th class="center">Exportar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carreras as $carrera)
            <tr>
                <td>{{$carrera->nombre}}</td>
                {{--<td class="center">{{$carrera->resolucion}}</td>--}}
                <td class="center">{{$carrera->anio_apertura}}</td>
                <td class="center">{{$carrera->vigente == 1? "Vigente":$carrera->anio_fin}}</td>
                <td><a href="{{route('admin.carreras.edit', ['carrera' => $carrera->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                <td class="flex-col items-center just-center spe">
                @if ($carrera->primeraAsignatura())
                    <a class="flex just-center" href="{{route('admin.cursadas.masivo',['asignatura'=>$carrera->primeraAsignatura()->id])}}">
                        <button class="spe-b1"><i class="ti ti-file-plus"></i>Cursadas</button>
                    </a>
                    <a class="flex just-center" href="{{route('admin.mesas.dual',['asignatura'=>$carrera->primeraAsignatura()->id])}}">
                        <button class="spe-b2"><i class="ti ti-file-plus"></i>Mesas</button>
                    </a>
                @endif
                </td>
                <td><a href="/admin/cursantes/carrera/{{$carrera->id}}"><button class="btn_blue"><i class="ti ti-file-download"></i>Cursadas</button></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
    <div class="w-1/2 mx-auto p-5 pagination">
        {{ $carreras->appends(request()->query())->links('Componentes.pagination') }}
    </div>
@endsection
