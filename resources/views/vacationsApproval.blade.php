@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('error') }}
    </div>
@endif
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Aprobar vacaciones</li>
  </ol>
  <div class="vacations-requested">
    <h4>Vacaciones pendientes de aprobación</h4>
    <form action="/vacaciones/actualizarestado" method="POST">  
    {{ csrf_field() }}
      <table class="table table-bordered" id="requestedVacations">
        <thead>
          <tr>
            <th scope="col">Día</th>
            <th scope="col">Colaborador</th>
            <th scope="col">Aprobar</th>
            <th scope="col">No aprobar</th>
            <th scope="col">Mantener pendiente</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($requestedDays as $day)
          <tr class="warning">
            <td>{{$day->fecha}}</td>
            <td>{{$day->nombre}} {{$day->apellidos}}</td>
            <td>
              <div class="form-check">
                <input class="form-check-input" name="group{{$day->id}}" type="radio" value="aprobado">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input class="form-check-input" name="group{{$day->id}}" type="radio" value="no aprobado">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input checked class="form-check-input" name="group{{$day->id}}" type="radio" value="pendiente">
              </div>
            </td>
            <input type="hidden" value="{{$day->id}}" name="id[]">
          </tr>
          @endforeach
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary" @if (count($requestedDays) == 0) disabled @endif>Actualizar estado</button>
    </form>
  </div>
  <div class="vacations-approved">
    <h4>Vacaciones aprobadas/no aprobadas</h4>
    <table class="table table-bordered" id="approvedVacations">
      <thead>
        <tr>
          <th>
          </th>
          <th scope="col">Día</th>
          <th scope="col">Colaborador</th>
          <th scope="col">Estado</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($approvedDays as $day)
        <tr class="{{ $day->estado=='aprobado' ? 'success' : 'danger'}}">
          <td>
            <form class="deleteVacation" action="/vacaciones/eliminar/{{$day->id}}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="DELETE" >
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
          </td>
          <td>{{$day->fecha}}</td>
          <td>{{$day->nombre}} {{$day->apellidos}}</td>
          <td>{{ ucfirst(trans($day->estado))}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
$(".deleteVacation").on("submit", function(){
  return confirm("¿Desea eliminar esta solicitud de vacaciones?");
});
</script> 
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection