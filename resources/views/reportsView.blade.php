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
    <li class="breadcrumb-item active">Reportes</li>
  </ol>
  </div>
  <div class="panel panel-info vacations-request">
    <div class="panel-heading">Crear nuevo reporte</div>
    <form action="/reportes/generar/datos" method="POST" id="reportsForm">
      {{ csrf_field() }}
      <div class="form-row">
          <label for="selectEmployee">Colaborador:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row">
          <label for="selectType">Tipo de reporte:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectType" id="selectType">
            <option value="datos">Datos colaborador</option>
            <option value="liquidacion">Liquidación colaborador</option>
            <option value="vacaciones">Vacaciones</option>
            <option value="incapacidades">Incapacidades</option>
            <option value="ausencias">Ausencias</option>
            <option value="contratos">Contratos</option>
            <option value="viaticos">Viáticos</option>
          </select>
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Generar</button>
        </div>  
      </div>
    </form>  
  </div>
</div> 
<script>
$(document).ready(function() {
  $('#selectType').on('change', function() {
    $('#reportsForm').attr('action', 'reportes/crear/'+this.value);  
  });
});
</script>  
@endsection