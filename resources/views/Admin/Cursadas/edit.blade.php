@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.cursadas.update', ['cursada'=>$cursada->id])}}">
        @csrf
        @method('put')

        <p>Alumno: {{$cursada->alumno->nombre.' '.$cursada->alumno->apellido}}</p>
        <p>Materia: {{$cursada->asignatura->nombre}}</p>
        <p>Año de cursada <input value="{{$cursada->anio_cursada}}" name="anio_cursada"></p>
        <p>Condicion 
            <select name="condicion">
                <option @selected($cursada->condicion==1) value="1">Libre</option>
                <option @selected($cursada->condicion==2) value="2">Precencial</option>
                <option @selected($cursada->condicion==3) value="3">Desertor</option>    
                <option @selected($cursada->condicion==4) value="4">Atraso acadamico</option>
                <option @selected($cursada->condicion==5) value="5">Otro</option>
            </select>    
        </p>
        <p>Aprobada 
            <select name="aprobada">
                <option @selected($cursada->aprobada==1) value="1">Si</option>
                <option @selected($cursada->aprobada==2) value="2">No</option>
                <option @selected($cursada->aprobada==3) value="3">Vacio</option>
            </select>    
        </p>

        <input type="submit" value="Actualizar">
       </form>
       @dd($cursada)
       <form method="post" action="{{route('admin.cursadas.destroy', ['cursada'=>$cursada->id])}}">
            @csrf
            @method('delete')
            <input type="submit" value="Borrar cursada">
        </form>
       
        

    </div>


@endsection