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
          <th></th>
          <th scope="col">Fecha ingreso</th>
          <th scope="col">Monto</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contracts as $contract)
        <tr class="info">
          <td>
            <form class="deleteExpense" action="/contratos/comprobacion/eliminar/{{$contract->id}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <input type="hidden" name="contractId" value="{{$contractId}}" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            <br>
            <button value="{{$contract->id}}" class="edit-expense btn btn-primary">Editar</button>
          </td>
          <td>{{$contract->fecha}}</td>
          <td>${{$contract->monto}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Ingresar nueva comprobación de contrato</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/contratos/comprobacion/ingresar" method="POST" id="show" class="collapse">
      {{ csrf_field() }}
      <div class="form-row {{ $errors->has('fecha') ? ' has-error' : '' }}">
        <label for="fecha">Fecha:<span class="required">*</span></label>
        <input onkeydown="return false" class="datepicker formatted" data-date-format="dd-mm-yyyy" name="fecha" required>
        @if ($errors->has('fecha'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('fecha') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-row">
        <label class="control-label" for="monto">Monto contrato:</label>
        <input type="hidden" value="{{$contractValue->monto}}" name="monto">
        <label class="formatted" id="monto" value="{{$contractValue->monto}}">${{$contractValue->monto}}</label>
      </div>
      <div class="form-row {{ $errors->has('cantidad') ? ' has-error' : '' }}">
        <label class="control-label" for="monto">Cantidad {{ $contractValue->forma_pago == 'mensual' ? 'meses' : 'horas'}}:<span class="required">*</span></label>
        <input class="formatted" name="cantidad" type="number" min="1" required>
        @if ($errors->has('cantidad'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('cantidad') }}</strong>
          </span>
        @endif    
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
  function openMenu() {
    $isCollapsed = $('.panel-heading').hasClass('collapsed');
    if ($isCollapsed) {
      $('.panel-heading').trigger('click');
    }  
  }
  
  setTimeout(() => {
    $(document).ready(function () {
      $('.datepicker').datepicker({
        language: 'es'
      });
    });

    $(".deleteExpense").on("submit", function(){
      return confirm("¿Desea eliminar esta comprobación?");
    });

    $(".edit-expense").click(function(el){
      $.get("/contratos/comprobacion/modificar/"+el.target.value, function(result){
        openMenu();
        $('.panel-heading span').text('Modificar comprobación');
        $('form#show button').text('Modificar');
        $('form#show').attr('action', '/contratos/comprobacion/modificar/'+ result.calculation.id);  
        //Fill Form
        $('input[name=fecha]')[0].value = result.calculation.fecha;
        $('label#monto')[0].value = result.calculation.contrato_monto;
        $('input[name=cantidad]')[0].value = result.calculation.monto / result.calculation.contrato_monto;
      });
    });
  }, 100);
</script> 
@endsection