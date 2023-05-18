@extends('Alumnos.layout')

@section('content')
<table>
    <tr>
      <th>Materia</th>
      <th>Aprobada</th>
      <th>Final</th>
    </tr>

        @foreach ($cursadas as $cursada) 
        <tr>
            {{-- nombre de cursada --}}
            <td>{{$cursada->materia->nombre}}</td>
            
            {{-- Si la aprobo o no --}}
            @if ($cursada->aprobada == 1)
                <td>si</td>
            @else
                <td>no</td>
            @endif

            {{-- Si aprobo el final --}}
            @if (in_array($cursada->id_asignatura,$examenesAprobados))
                <td>Aprobado</td>
            @else
                <td>Desprobado / Sin rendir</td>
            @endif
            
        </tr>
        @endforeach
    </table>

@endsection