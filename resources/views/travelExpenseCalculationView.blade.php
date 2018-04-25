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
          <th></th>
          <th scope="col">Fecha</th>
          <th scope="col">Tipo</th>
          <th scope="col">Descripción</th>
          <th scope="col">Monto</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr class="info">
          <td>
            <form class="deleteExpense" action="/viaticos/comprobacion/eliminar/{{$expense->id}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <input type="hidden" name="expenseId" value="{{$expenseId}}" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            <br>
            <button value="{{$expense->id}}" class="edit-expense btn btn-primary">Editar</button>
          </td>
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
          <td> </td>
          <td><strong>Total: ${{$total->total}}</strong></td>
        <tr>
        <tr>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td><strong>Reportado: ${{$reported}}</strong></td>
        <tr>
        <tr class="{{$total->total - $reported == 0 ? 'success' : 'danger'}}">
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td><strong>Diferencia: ${{$total->total - $reported}}</strong></td>
        <tr>  
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Ingresar nueva comprobación de viático</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/viaticos/comprobacion/ingresar" method="POST" id="show" class="collapse">
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
      <div class="form-row {{ $errors->has('descripcion') ? ' has-error' : '' }}">
        <label class="control-label" for="descripcion">Descripción:<span class="required">*</span></label>
        <textarea class="formatted" name="descripcion" required></textarea>
        @if ($errors->has('descripcion'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('descripcion') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-row {{ $errors->has('fecha') ? ' has-error' : '' }}">
        <label class="control-label" for="fecha">Fecha:<span class="required">*</span></label>
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
      <div class="form-row {{ $errors->has('monto') ? ' has-error' : '' }}">
        <label class="control-label" for="monto">Monto en $:<span class="required">*</span></label>
        <input class="formatted" name="monto" type="number" min="1" required>
        @if ($errors->has('monto'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('monto') }}</strong>
          </span>
        @endif
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
      $.get("/viaticos/comprobacion/modificar/"+el.target.value, function(result){
        openMenu();
        $('.panel-heading span').text('Modificar comprobación');
        $('form#show button').text('Modificar');
        $('form#show').attr('action', '/viaticos/comprobacion/modificar/'+ result.calculation.id);  
        //Fill Form
        $('select[name=selectType]')[0].value = result.calculation.tipo;
        $('input[name=fecha]')[0].value = result.calculation.fecha;
        $('input[name=monto]')[0].value = result.calculation.monto;
        $('textarea[name=descripcion]')[0].value = result.calculation.descripcion;
      });
    });
  }, 100);
</script> 
@endsection