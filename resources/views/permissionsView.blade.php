@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Permisos</li>
  </ol>
  <div class="permissions-requested">
    <h4>Permisos de ausencia solicitados</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th scope="col">Día</th>
          <th scope="col">Estado</th>
          <th scope="col">Cantidad de horas</th>
          <th scope="col">Comentarios</th>
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
          <td>{{ $day->cant_horas }}</td>
          <td>{{ $day->comentarios }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Solicitar permiso de ausencia</div>
    <form action="/permisos/solicitar" method="POST">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="manager">Manager:</label>
        <label name="manager" >{{$empleado->admin_nombre}} {{$empleado->admin_apellidos}}</label>
      </div>
      <div class="form-row">
        <label for="dia">Día a solicitar:<span class="required">*</span></label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="dia">
        @if ($errors->has('dia'))
          <span class="label label-danger">
              <strong>{{ $errors->first('dia') }}</strong>
          </span>
        @endif
      </div>  
      <div class="form-row">
        <label for="cantidad">Cantidad de horas:<span class="required">*</span></label>
        <input class="formatted" type="number" name="cantidad" min="0" required>
      </div>
      <div class="form-row">
        <label for="comentarios">Comentarios:<span class="required">*</span></label>
        <textarea class="formatted" name="comentarios" required></textarea>
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Solicitar</button>
        </div>  
      </div>
      <input name="empleado" type="hidden" value="{{$empleado->cedula}}">
    </form>
  <div>
</div>
<script>
  setTimeout(() => {
    $(document).ready(function () {
      $('.datepicker').datepicker({
        startDate: '+1d',
        daysOfWeekDisabled: [0,6]
      });
    });
  }, 100);
</script>  
@endsection