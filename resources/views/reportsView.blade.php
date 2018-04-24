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
  <div class="panel panel-info report-container">
    <div class="panel-heading">Crear nuevo reporte</div>
    <form action="/reportes/generar/datos" method="POST" id="reportsForm">
      {{ csrf_field() }}
      <div class="form-row">
          <label for="selectType">Tipo de reporte:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectType" id="selectType">
            <option value="datos">Datos empleado(a)</option>
            <option value="liquidacion">Liquidacion de empleado(a)</option>
            <option value="vacaciones">Vacaciones</option>
            <option value="incapacidades">Incapacidades</option>
            <option value="ausencias">Ausencias</option>
            <option value="viaticos">Viáticos</option>
            <option value="contratos">Contratos</option>
          </select>
      </div>
      <div class="form-row">
          <label for="selectEmployee">Empleado(a):<span class="required">*</span></label>
          <select class="form-control formatted" id="selectEmployee" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row contract-selector">
          <label for="selectEmployee">Contrato:<span class="required">*</span></label>
          <select class="form-control formatted" id="selectContract" name="selectContract">
          </select>
      </div>
      <div class="form-row expense-selector">
          <label for="selectEmployee">Viático:<span class="required">*</span></label>
          <select class="form-control formatted" id="selectExpense" name="selectExpense">
          </select>
      </div>
      <div class="form-row settle-selector">
          <label for="selectEmployee">Motivo salida:<span class="required">*</span></label>
          <select class="form-control formatted" id="selectSettle" name="selectSettle">
            <option value="settle1">Renuncia</option>
            <option value="settle2">Despido con responsabilidad patronal</option>
            <option value="settle3">Despido sin responsabilidad patronal</option>
          </select>
      </div>
      <div class="form-row settle-out">
        <label for="dia">Fecha salida:<span class="required">*</span></label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd/mm/yyyy" name="fecha_salida">
        @if ($errors->has('fecha_salida'))
          <script>
            $(".settle-out, .settle-selector").show();
            $('#selectType')[0].value = 'liquidacion';
          </script>  
          <span class="label label-danger">
              <strong>{{ $errors->first('fecha_salida') }}</strong>
          </span>
        @else
          <script>
            $(".settle-out, .settle-selector").hide();
          </script>  
        @endif
      </div> 
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" id="createReport" class="btn btn-primary">Generar</button>
        </div>  
      </div>
    </form>  
  </div>
</div> 
<script>
$(document).ready(function() {
  $('.datepicker').datepicker({
    startDate: '+1d',
    daysOfWeekDisabled: [0,6],
    language: 'es'
  });

  $(".expense-selector, .contract-selector").hide();

  $('#selectType').on('change', function() {
    $('#reportsForm').attr('action', '/reportes/generar/'+this.value); 
    $('.expense-selector').hide(); 
    $('.contract-selector').hide(); 
  });

  $('#selectExpense').on('change', function() {
    $('#reportsForm').attr('action', '/reportes/generar/viaticos'+this.value);  
  });

  $('#selectType, #selectEmployee').on('change', function() {
    $('#createReport').prop("disabled",false);
    if ($('#selectType')[0].value == "viaticos") {
      $('.expense-selector').show();
      $empId = $('select[name=selectEmployee]')[0].value;
      $.get("/viaticos/empleado-todo/"+$empId, function(result){
        $('#selectExpense option').remove();
        var x = document.getElementById("selectExpense");
        if (result.expenses.length > 0) {
          $('#reportsForm').attr('action', '/reportes/generar/viaticos/'+result.expenses[0].id);
          for (var i=0; i< result.expenses.length; i++) {
            var option = document.createElement("option");
            option.text = result.expenses[i].tipo + ' - ' + result.expenses[i].fecha + ' - $' + result.expenses[i].total;
            option.value = result.expenses[i].id;
            x.add(option);
          }
        }else {
          var option = document.createElement("option");
          option.text = "No existen datos";
          x.add(option);
          $('#createReport').prop("disabled",true);
        }
      });  
    } 
    if ($('#selectType')[0].value == "contratos") {
      $('.contract-selector').show();
      $empId = $('select[name=selectEmployee]')[0].value;
      $.get("/contratos/empleado/"+$empId, function(result){
        $('#selectContract option').remove();
        var x = document.getElementById("selectContract");
        if (result.contracts.length > 0) {
          $('#reportsForm').attr('action', '/reportes/generar/contratos/'+result.contracts[0].id);
          for (var i=0; i< result.contracts.length; i++) {
            var option = document.createElement("option");
            option.text = result.contracts[i].nombre;
            option.value = result.contracts[i].id;
            x.add(option);
          }
        }else {
          var option = document.createElement("option");
          option.text = "No existen datos";
          x.add(option);
          $('#createReport').prop("disabled",true);
        }
      });  
    }
    if ($('#selectType')[0].value == "liquidacion") {
      $(".settle-out, .settle-selector").show();
    } else {
      $(".settle-out, .settle-selector").hide();
    }
  });


});
</script>  
@endsection