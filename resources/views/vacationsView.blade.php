@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Vacaciones</li>
  </ol>
  <h3>Días disponibles de vacaciones: <span class="label label-info">{{$availableDays}}</span></h3>
  <div class="vacations-requested">
    <h4>Vacaciones solicitadas</h4>
    <table class="table table-bordered" id="requestedVacations">
      <thead>
        <tr>
          <th scope="col">Día</th>
          <th scope="col">Estado</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($requestedDays as $day)
        @if ($day->estado == 'aprobado')
        <tr class="success">
        @elseif($day->estado == 'pendiente')
        <tr class="warning">
        @else
        <tr class="danger">
        @endif
          <td>{{$day->fecha}}</td>
          <td>{{ ucfirst(trans($day->estado)) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info vacations-request">
    <div class="panel-heading">Solicitar vacaciones</div>
    <form>
      <div class="form-row">
        <label for="dias">Día(s) a solicitar:<span class="required">*</span></label>
        <input class="datepicker" data-date-format="mm/dd/yyyy">
      </div>  
      <div class="form-row">
        <label for="manager">Manager:</label>
        <label name="manager">{{$empleado->admin_nombre}} {{$empleado->admin_apellidos}}</label>
      </div>
      <div class="form-row">
        <label for="copia">Enviar copia a:</label>
        @foreach ($admins as $admin)
          @if($admin->cedula != $empleado->id_manager)
          <div class="checkbox">
            <label>
              <input class="form-check-input" type="checkbox" value="{{$admin->cedula}}">{{$admin->nombre}} {{$admin->apellidos}}</input>
            </label>
          </div>
          @endif
        @endforeach
      </div>
      <div class="form-row">
        <button type="submit" class="btn btn-primary">Solicitar</button>
      </div>
    </form>
  <div>
</div> 
<script>
  setTimeout(() => {
    $(document).ready(function () {
      $('.datepicker').datepicker({
        startDate: '+0d',
        multidate: true
      });
    });
  }, 100);
</script>  
@endsection