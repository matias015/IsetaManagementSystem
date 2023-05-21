@extends('Alumnos.layout')

@section('content')
<table>
    <tr>
        <th>Materia</th>
        <th>Nota mas alta</th>
    </tr>
    
    
    @foreach($examenes as $examen)
        <tr>
            <td>{{$textFormatService->utf8Minusculas($examen->nombre)}}</td>
            <td>{{$examen->nota}}</td>
        </tr>
    
    @endforeach
    
</table>
@endsection

           
  