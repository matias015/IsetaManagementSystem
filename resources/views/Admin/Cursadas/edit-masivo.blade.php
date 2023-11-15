@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Cargar resultados de cursadas</h2>
                <form method="POST" action="{{route('admin.config.setone')}}">
                    @csrf
                    Año
                    
                    <input class="black" name="anio_ciclo_actual" value="{{$config['anio_ciclo_actual']}}" type="number">
                    <button class="p-1 bg-blue-800 rounded">Cambiar año</button>
                </form>
            </div>

            <div class="perfil__info">
                
                <h2>{{$asignatura->carrera->nombre}}</h2>
                <p>{{$asignatura->anioStr()}}</p><br>
                
                

                <div class="grid-3 gridx-center gap-4">
                    <div>
                        <p>siguiente</p>
                        @if ($anterior)
                            <a class="blue-600" href="{{route('admin.cursadas.masivo', ['asignatura'=>$anterior->id])}}">{{$anterior->nombre}}</a>
                        @endif
                    </div>
                    <div>
                        <p>actual</p>
                        {{$asignatura->nombre}}
                    </div>
                    <div>
                        <p>siguiente</p>
                        @if ($siguiente)
                            <a class="blue-600" href="{{route('admin.cursadas.masivo', ['asignatura'=>$siguiente->id])}}">{{$siguiente->nombre}}</a>
                        @endif
                    </div>
                </div>
            <br><br>

                <form method="POST" action="{{route('admin.cursadas.masivo.post')}}">
                    @csrf
                    @foreach($asignatura->cursadas as $cursada)
                      <div class="grid-3">
                        <span class="span-2">{{$cursada->alumno->apellidoNombre()}}</span>
                        <select name="{{$cursada->id}}">
                            <option @selected($cursada->condicion==1 && $cursada->aprobada==3) value="rc">Regular cursando</option>
                            <option @selected($cursada->condicion==1 && $cursada->aprobada==2) value="rd">Regular desaprobado</option>
                            <option @selected($cursada->condicion==1 && $cursada->aprobada==1) value="ra">Regular aprobado</option>
                            <option @selected($cursada->condicion==0) value="l">Libre</option>
                            <option @selected($cursada->condicion==3) value="e">Equivalencia</option>
                            <option @selected($cursada->condicion==2) value="p">Promoción</option>
                        </select>
                      </div>
                    @endforeach
                    <button>Cargar</button>
                  </form>

                  <br>
                  <br>
                  <br>

                  <div class="flex-col">
                    @foreach ($carreras as $carrera)
                        @if ($carrera->primeraAsignatura())
                            @if ($carrera->id == $asignatura->carrera->id)
                                <p class="text-left gray-700" href="{{route('admin.cursadas.masivo',['asignatura'=>$carrera->primeraAsignatura()->id])}}">
                                    {{$carrera->nombre}}                       
                                </p>    
                            @else
                                <a class="text-left blue-700" href="{{route('admin.cursadas.masivo',['asignatura'=>$carrera->primeraAsignatura()->id])}}">
                                    {{$carrera->nombre}}                       
                                </a>     
                            @endif
                        @endif
                    @endforeach
                  </div>

                
            </div>
  
        </div>
    </div>

    <script src="{{asset('js/obtener-materias.js')}}"></script>

@endsection




 
  
  
