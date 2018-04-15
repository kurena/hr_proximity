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
    <h4>Incapacidades ingresadas</h4>
    <table class="table table-bordered" id="incapacity-view">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Fecha Inicio</th>
          <th scope="col">Fecha Fin</th>
          <th scope="col">Empleado</th>
          <th scope="col">Comentarios</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activeDays as $day)
        <tr class="success">
          <td>
          <form class="deleteIncapacity" action="/incapacidades/eliminar/{{$day->id}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            <br>
            <button value="{{$day->id}}" class="edit-incapacity btn btn-primary">Editar</button>
          </td>
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
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Ingresar nueva incapacidad</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/incapacidades/ingresar" method="POST" id="show" class="collapse">
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
          <label for="selectEmployee">Empleado:<span class="required">*</span></label>
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

      $(".deleteIncapacity").on("submit", function(){
        return confirm("¿Desea eliminar esta incapacidad?");
      });

      $(".edit-incapacity").click(function(el){
        $.get("/incapacidades/modificar/"+el.target.value, function(result){
          //If Collapsed then open
          $isCollapsed = $('.panel-heading').hasClass('collapsed');
          if ($isCollapsed) {
            $('.panel-heading').trigger('click');
          }
          $('.panel-heading span').text('Modificar incapacidad');
          $('form#show button').text('Modificar');
          $('form#show').attr('action', '/incapacidades/modificar/'+ result.incapacity.id);  
          //Fill Form
          $('input[name=fecha_inicio]')[0].value = result.incapacity.fecha_inicio;
          $('input[name=fecha_fin]')[0].value = result.incapacity.fecha_inicio;
          $('select[name=selectEmployee]')[0].value = result.incapacity.id_empleado;
          $('textarea[name=comentarios]')[0].value = result.incapacity.comentarios;
        });
      });
    });
  }, 100);
</script>  
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection