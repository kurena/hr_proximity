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
    <li class="breadcrumb-item active">Incapacidades</li>
  </ol>
  <div class="permissions-requested">
    <h4>Activas al día de hoy</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th scope="col">Fecha Inicio</th>
          <th scope="col">Fecha Fin</th>
          <th scope="col">Colaborador</th>
          <th scope="col">Comentarios</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activeDays as $day)
        <tr class="success">
          <td>{{$day->fecha_inicio}}</td>
          <td>{{$day->fecha_fin}}</td>
          <td>{{$day->nombre}} {{$day->apellidos}}</td>
          <td>{{$day->comentarios}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Ingresar nueva incapacidad</div>
    <form action="/incapacidades/ingresar" method="POST">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="dia">Fecha inicio:<span class="required">*</span></label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="fecha_inicio">
      </div>  
      <div class="form-row">
        <label for="dia">Fecha fin:<span class="required">*</span></label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="fecha_fin">
      </div>
      <div class="form-row">
          <label for="selectEmployee">Colaborador:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row">
        <label for="comentarios">Comentarios:<span class="required">*</span></label>
        <textarea class="formatted" name="comentarios" required></textarea>
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>  
      </div>
    </form>
  <div>
</div>
<script>
  setTimeout(() => {
    $(document).ready(function () {
      $('.datepicker').datepicker({
        startDate: '+1d',
        daysOfWeekDisabled: [0,6],
        language: 'es'
      });
    });
  }, 100);
</script>  
@endsection