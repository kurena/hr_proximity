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
    <li class="breadcrumb-item"><a href="/contratos">Contratos</a></li>
    <li class="breadcrumb-item active">Comprobación</li>
  </ol>
  <div class="permissions-requested">
    <h4>Comprobación de Contratos</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Monto</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contracts as $contract)
        <tr class="info">
          <td>{{$contract->fecha}}</td>
          <td>${{$contract->monto}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Ingresar nueva comprobación de contrato</div>
    <form action="/contratos/comprobacion/ingresar" method="POST">
      {{ csrf_field() }}
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
      <input type="hidden" value="{{$contractId}}" name="contractId">
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