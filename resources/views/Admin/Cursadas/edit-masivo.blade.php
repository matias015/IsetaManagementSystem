@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Cargar resultados de cursadas</h2>
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
                          <option @selected($cursada->condicion==1 && $cursada->aprobada==2) value="rd">Regular desaprobado</option>
                          <option @selected($cursada->condicion==1 && $cursada->aprobada==1) value="ra">Regular aprobado</option>
                          <option @selected($cursada->condicion==0 && $cursada->aprobada==1) value="l">Libre</option>
                          <option @selected($cursada->condicion==3 && $cursada->aprobada==1) value="e">Equivalencia</option>
                          <option @selected($cursada->condicion==2 && $cursada->aprobada==1) value="p">Promoción</option>
                        </select>
                      </div>
                    @endforeach
                    <button>Cargar</button>
                  </form>

                  <br>
                  <br>
                  <br>


                
            </div>
  
        </div>
    </div>

    <script src="{{asset('js/obtener-materias.js')}}"></script>

@endsection




 
  
  
