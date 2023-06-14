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

       
        <p>Alumno: {{$examen->alumno->nombre}}</p>
        <p>Materia: {{$examen->mesa->materia->nombre}}</p>
        <p>Carrera: {{$examen->mesa->materia->carrera->nombre}}</p>
        <p>Año: {{$examen->mesa->materia->anio +1}}</p>
        <p>Fecha: {{$examen->mesa->fecha}}</p>
        <p>Presidente: {{$examen->mesa->profesor->nombre . ' '.$examen->mesa->profesor->apellido}}</p>
        <p>vocal1: {{$examen->mesa->vocal1? $examen->mesa->vocal1->nombre . ' ' . $examen->mesa->vocal1->apellido : 'No hay'}}</p>
        <p>vocal2: {{$examen->mesa->vocal2? $examen->mesa->vocal2->nombre . ' ' . $examen->mesa->vocal2->apellido : 'No hay'}}</p>
        <p>llamado: {{$examen->mesa->llamado? $examen->mesa->llamado : 'No hay datos sobre el llamado'}}</p>

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
            <input type="submit" value="Borrar cursada">
        </form>
       
        


    </div>
</div>

@endsection