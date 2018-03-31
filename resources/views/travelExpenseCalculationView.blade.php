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
    <li class="breadcrumb-item"><a href="/viaticos/empleado/{{$empleado->cedula}}">Viáticos</a></li>
    <li class="breadcrumb-item active">Comprobación</li>
  </ol>
  <div class="permissions-requested">
    <h4>Comprobación de Víaticos</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Tipo</th>
          <th scope="col">Descripción</th>
          <th scope="col">Monto</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr class="info">
          <td>{{$expense->fecha}}</td>
          <td>{{ucfirst(trans($expense->tipo))}}</td>
          <td>{{$expense->descripcion}}</td>
          <td>${{$expense->monto}}</td>
        </tr>
        @endforeach
        <tr>
          <td> </td>
          <td> </td>
          <td> </td>
          <td><strong>Total: ${{$expense->total}}</strong></td>
        <tr>
        <tr>
          <td> </td>
          <td> </td>
          <td> </td>
          <td><strong>Reportado: ${{$reported}}</strong></td>
        <tr>
        <tr class="{{$expense->total - $reported == 0 ? 'success' : 'danger'}}">
          <td> </td>
          <td> </td>
          <td> </td>
          <td><strong>Diferencia: ${{$expense->total - $reported}}</strong></td>
        <tr>  
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Ingresar nueva comprobación de viático</div>
    <form action="/viaticos/comprobacion/ingresar" method="POST">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="dia">Tipo:<span class="required">*</span></label>
        <select class="form-control formatted" name="selectType">
          <option value="hospedaje">Hospedaje</option>
          <option value="tiquete aéreo">Tiquete aéreo</option>
          <option value="transporte">Transporte</option>
          <option value="alimentación">Alimentación</option>
          <option value="seguro">Seguro</option>
          <option value="reintegro">Reintegro</option>
          <option value="otro">Otro</option>
        </select>
      </div>
      <div class="form-row">
        <label for="descripcion">Descripción:<span class="required">*</span></label>
        <textarea class="formatted" name="descripcion" required></textarea>
      </div>
      <div class="form-row">
        <label for="fecha">Fecha:<span class="required">*</span></label>
        <input onkeydown="return false" class="datepicker formatted" data-date-format="dd-mm-yyyy" name="fecha">
      </div>
      <div class="form-row">
        <label for="monto">Monto en $:<span class="required">*</span></label>
        <input class="formatted" name="monto" type="number" min="0" required>
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>  
      </div>
      <input type="hidden" value="{{$expenseId}}" name="expenseId">
    </form>
  </div>
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
@endsection