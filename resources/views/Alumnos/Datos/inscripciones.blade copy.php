@extends('Alumnos.layout')

@section('content')
    
    <h1>Inscribirme</h1>
    
    <div style="display:flex; flex-direction:column;">

        @foreach($materias as $materia)
            @php
                
            $yaAnotado=false; 
            $sinMesas=false;
            
            if(count($materia->mesas) < 1)$sinMesas=true;
            else {
                foreach($materia->mesas as $mesa){
                    if(in_array($mesa->id, $yaAnotadas)) $yaAnotado=$mesa;
                }
            }

            $path = $yaAnotado? "alumno.bajarse":"alumno.inscribirse";
            $btnTexto = $yaAnotado? "desinscribirme":"inscribirme"; 
            
            @endphp
            <p>{{$materia->nombre}}</p>
            <form action="{{route($path)}}" method="post" style="display:flex; flex-direction:column;">
            @csrf
                @if($yaAnotado)
                    @component('Comp.desinscripcion-form')
                        @slot('mesa', $yaAnotado)
                    @endcomponent
                
                @elseif($sinMesas) 
                    <p>No hay mesas</p>
                @else    
                    @foreach($materia -> mesas as $mesa)
                        @component('Comp.inscripcion-form')
                            @slot('mesa', $mesa)
                        @endcomponent
                    @endforeach
                @endif

                <input type='submit' value="{{$btnTexto}}">
            </form>
            
        @endforeach
    
</div>
    

@endsection
