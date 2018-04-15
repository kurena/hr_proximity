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
    <li class="breadcrumb-item active">Viáticos</li>
  </ol>
  <div class="permissions-requested">
    <h4>Viáticos</h4>
    <table class="table table-bordered" id="travel-expense">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Fecha ingreso</th>
          <th scope="col">Tipo</th>
          <th scope="col">Empleado</th>
          <th scope="col">Monto total</th>
          <th scope="col">Descripción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr class="success">
          <td>
            <form action="/viaticos/comprobacion/{{$expense->id}}" method="get">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="GET" >
              <button type="submit" class="btn btn-primary">Comprobación</button>
            </form>
            <br>
            <form class="deleteExpense" action="/viaticos/eliminar/{{$expense->id}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            <br>
            <button value="{{$expense->id}}" class="edit-expense btn btn-primary">Editar</button>
          </td>
          <td>{{$expense->fecha}}</td>
          <td>{{ucfirst(trans($expense->tipo))}}</td>
          <td>{{$expense->nombre}} {{$expense->apellidos}}</td>
          <td>${{$expense->total}}</td>
          <td>{{$expense->descripcion}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Ingresar nuevo viático</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/viaticos/ingresar" method="POST" id="show" class="collapse">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="dia">Tipo:<span class="required">*</span></label>
        <select class="form-control formatted" name="selectType">
          <option value="viaje">Viaje</option>
          <option value="otro">Otro</option>
        </select>
      </div>
      <div class="form-row">
          <label for="selectEmployee">Empleado:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row">
        <label for="comentarios">Descripción:<span class="required">*</span></label>
        <textarea class="formatted" name="descripcion" required></textarea>
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
    </form>
  </div>
</div>
<script>
  $(document).ready(function () {
    $(".deleteExpense").on("submit", function(){
      return confirm("¿Desea eliminar este viatico?");
    });
    $(".edit-expense").click(function(el){
      $.get("/viaticos/modificar/"+el.target.value, function(result){
        //If Collapsed then open
        $isCollapsed = $('.panel-heading').hasClass('collapsed');
        if ($isCollapsed) {
          $('.panel-heading').trigger('click');
        }
        $('.panel-heading span').text('Modificar viatico');
        $('form#show button').text('Modificar');
        $('form#show').attr('action', '/viaticos/modificar/'+ result.expense.id);  
        //Fill Form
        $('select[name=selectType]')[0].value = result.expense.tipo;
        $('select[name=selectEmployee]')[0].value = result.expense.id_empleado;
        $('input[name=monto]')[0].value = result.expense.total;
        $('textarea[name=descripcion]')[0].value = result.expense.descripcion;
      });
    });
  });
</script>  
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection