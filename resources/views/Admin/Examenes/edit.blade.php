@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

<div class="edit-form-container">
       <form method="post" action="{{route('admin.examenes.update', ['examen'=>$examen->id])}}">
        @csrf
        @method('put')

        <h2>Alumno</h2>
        <p>Alumno: {{$examen->alumno->nombre}}</p>

        <h2>Asignatura</h2>
        <p>Materia: {{$examen->asignatura->nombre}}</p>
        <p>Carrera: {{$examen->asignatura->carrera->nombre}}</p>
        <p>Año: {{$examen->asignatura->anio +1}}</p>
        
            <h2>Mesa</h2>
        @if (isset($examen->mesa))
            <p>Presidente: {{$examen->mesa->profesor->nombre . ' '.$examen->mesa->profesor->apellido}}</p>
            <p>vocal1: {{$examen->mesa->vocal1? $examen->mesa->vocal1->nombre . ' ' . $examen->mesa->vocal1->apellido : 'No hay'}}</p>
            <p>vocal2: {{$examen->mesa->vocal2? $examen->mesa->vocal2->nombre . ' ' . $examen->mesa->vocal2->apellido : 'No hay'}}</p>
            <p>llamado: {{$examen->mesa->llamado? $examen->mesa->llamado : 'No hay datos sobre el llamado'}}</p>
        @else
            <p>No hay informacion de la mesa, esto es debido a que cuando se registro la inscripcion, no se especifico una mesa por parte de iseta</p>    
        @endif

        <h2>Examen</h2>
        <p>Fecha: {{$examen->fecha? $examen->fecha : 'Sin rendir'}}</p>
        <p>nota <input name="nota" value="{{$examen->nota}}"></p>
        <p>Ausente <input @checked($examen->aprobado == 3) name="ausente" type="checkbox"></p>

        <p>tipo de final

            
        <select name="tipo_final">
            <option value="1">escrito</option >
            <option value="2">oral</option>
            <option value="3">promocionado</option> 
        </select>
      
    
    </p>
    <p>libro <input name="libro" value="{{$examen->libro}}"></p>
    <p>acta <input name="acta" value="{{$examen->acta}}"></p>


    <input type="submit" value="Actualizar">
       </form>

       <form method="post" action="{{route('admin.examenes.destroy', ['examen'=>$examen->id])}}">
            @csrf
            @method('delete')
            boton para borrar comentado 
            {{-- <input type="submit" value="Borrar registro de examen"> --}}
        </form>
       
        


    </div>
</div>

@endsection