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
    <li class="breadcrumb-item active">Permisos</li>
  </ol>
  <div class="permissions-requested">
    <h4>Permisos de ausencia solicitados</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th></th>
          <th scope="col">Día</th>
          <th scope="col">Estado</th>
          <th scope="col">Cantidad de horas</th>
          <th scope="col">Reposición de horas</th>
          <th scope="col">Comentarios</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($requestedDays as $day)
        @if ($day->estado == 'aprobado')
        <tr class="success">
        @elseif($day->estado == 'pendiente')
        <tr class="warning">
        @else
        <tr class="danger">
        @endif
          <td>  
            @if ($day->estado == 'pendiente')
              <form class="deletePermission" action="/permisos/eliminar/{{$day->id}}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="_method" value="DELETE" >
                  <button type="submit" class="btn btn-primary">Eliminar</button>
              </form>
              <br>
              <button value="{{$day->id}}" class="edit-permission btn btn-primary">Editar</button>
            @endif
          </td>  
          <td>{{$day->fecha}}</td>
          <td>{{ ucfirst(trans($day->estado)) }}</td>
          <td>{{ $day->cant_horas }}</td>
          <td>{{ $day->reposicion == 0 ? 'No' : 'Sí' }}</td>
          <td>{{ $day->comentarios }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Solicitar permiso de ausencia</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/permisos/solicitar" method="POST" id="show" class="collapse">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="manager">Manager:</label>
        <label name="manager" >{{$empleado->admin_nombre}} {{$empleado->admin_apellidos}}</label>
      </div>
      <div class="form-row {{ $errors->has('dia') ? ' has-error' : '' }}">
        <label class="control-label" for="dia">Día a solicitar:<span class="required">*</span></label>
        <input class="formatted datepicker" onkeydown="return false" data-date-format="dd-mm-yyyy" name="dia" required>
        @if ($errors->has('dia'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('dia') }}</strong>
          </span>
        @endif
      </div>  
      <div class="form-row {{ $errors->has('cantidad') ? ' has-error' : '' }}">
        <label class="control-label" for="cantidad">Cantidad de horas:<span class="required">*</span></label>
        <input class="formatted" type="number" name="cantidad" min="1" required>
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
        <label for="dia">Reposición de horas:<span class="required">*</span></label>
        <select class="form-control formatted" name="reposicion">
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
      </div>
      <div class="form-row {{ $errors->has('comentarios') ? ' has-error' : '' }}">
        <label class="control-label" for="comentarios">Comentarios:<span class="required">*</span></label>
        <textarea class="formatted" name="comentarios" required></textarea>
        @if ($errors->has('comentarios'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('comentarios') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Solicitar</button>
        </div>  
      </div>
      <input name="empleado" type="hidden" value="{{$empleado->cedula}}">
    </form>
  <div>
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
        startDate: '+1d',
        daysOfWeekDisabled: [0,6],
        language: 'es'
      });
    });

    $(".deletePermission").on("submit", function(){
        return confirm("¿Desea eliminar esta solicitud de permiso de ausencia?");
    });

    $(".edit-permission").click(function(el){
      $.get("/permisos/modificar/"+el.target.value, function(result){
        //If Collapsed then open
        openMenu();
        $('.panel-heading span').text('Modificar solicitud');
        $('form#show button').text('Modificar');
        $('form#show').attr('action', '/permisos/modificar/'+ result.permission.id);  
        //Fill Form
        $('input[name=dia]')[0].value = result.permission.fecha;
        $('input[name=cantidad]')[0].value = result.permission.cant_horas;
        $('select[name=reposicion]')[0].value = result.permission.reposicion;
        $('textarea[name=comentarios]')[0].value = result.permission.comentarios;
      });
    });

  }, 100);
</script> 
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script> 
@endsection