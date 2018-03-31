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
    <li class="breadcrumb-item active">Dashboard de contratos</li>
  </ol>
  <div class="permissions-requested contracts-dashboard">
    <h4>Dashboard de contratos</h4>
    <table class="table table-bordered" id="contracts-dashboard">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Tipo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Fecha inicio</th>
          <th scope="col">Fecha fin</th>
          <th scope="col">Colaborador asignado</th>
          <th scope="col">Forma pago</th>
          <th scope="col">Monto</th>
          <th scope="col">Multa</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contracts as $contract)
        <tr class="">
          <td>
            <form action="/contratos/comprobacion/{{$contract->id}}" method="get">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="GET" >
              <button type="submit" class="btn btn-primary">Comprobación</button>
            </form>
          </td>
          <td>{{ucfirst(trans($contract->tipo))}}</td>
          <td>{{$contract->nombre_contrato}}</td>
          <td>{{$contract->fecha_inicio}}</td>
          <td>{{$contract->fecha_fin == NULL ? 'N/A' : $contract->fecha_fin}}</td>
          <td>{{$contract->nombre}} {{$contract->apellidos}}</td>
          <td>{{ucfirst(trans($contract->forma_pago))}}</td>
          <td>${{$contract->monto}}</td>
          <td>{{$contract->multa <= 0 ? 'N/A' : '$'.$contract->multa}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Ingresar nuevo contrato</div>
    <form action="/contratos/ingresar" method="POST">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="dia">Tipo:<span class="required">*</span></label>
        <select class="form-control formatted" name="selectType">
          <option value="outsorcing">Outsorcing</option>
          <option value="cliente">Cliente</option>
        </select>
      </div>
      <div class="form-row">
        <label for="monto">Nombre contrato:<span class="required">*</span></label>
        <input class="formatted" name="nombre_contrato" type="text" required>
      </div>
      <div class="form-row">
        <label for="fecha_inicio">Fecha inicio:<span class="required">*</span></label>
        <input required class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="fecha_inicio">
      </div>
      <div class="form-row">
        <label for="fecha_fin">Fecha fin:</label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="fecha_fin">
      </div>
      <div class="form-row">
          <label for="selectEmployee">Colaborador asignado:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row">
        <label for="dia">Forma pago:<span class="required">*</span></label>
        <select class="form-control formatted" name="selectPayType">
          <option value="mensual">Mensual fijo</option>
          <option value="horas">Horas</option>
        </select>
      </div>
      <div class="form-row">
        <label for="monto">Monto en $:<span class="required">*</span></label>
        <input class="formatted" name="monto" type="number" min="0" required>
      </div>
      <div class="form-row">
        <label for="multa">Multa en $:<span class="required">*</span></label>
        <input class="formatted" name="multa" type="number" min="0">
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
        language: 'es'
      });
    });
  }, 100);
</script>  
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection