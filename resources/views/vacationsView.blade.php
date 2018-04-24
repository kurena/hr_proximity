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
    <li class="breadcrumb-item active">Vacaciones</li>
  </ol>
  <h3>Días disponibles de vacaciones: <span class="label label-info">{{$availableDays}}</span></h3>
  <div class="vacations-period">
  <h4>Desgloce días disponibles por períodos</h4>
  @foreach ($periods as $period)
    <span>Del {{$period["start"]}} al {{$period["end"]}}: <strong>{{$period["days"]}}</strong> dia(s) disponibles</span>
    <br>
  @endforeach
  </div>
  <div class="vacations-requested">
    <h4>Vacaciones solicitadas</h4>
    <table class="table table-bordered" id="requestedVacations">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Día</th>
          <th scope="col">Estado</th>
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
            <form class="deleteVacation" action="/vacaciones/eliminar/{{$day->id}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            <br>
            <button value="{{$day->id}}" class="edit-vacation btn btn-primary">Editar</button>
            @endif
          </td>
          <td>{{$day->fecha}}</td>
          <td>{{ ucfirst(trans($day->estado)) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info vacations-request">
    <div href="#show" data-toggle="collapse" class="panel-heading collapsed"><span>Solicitar vacaciones</span><i class="show-menu fas fa-chevron-circle-down fa-lg"></i><i class="hide-menu fas fa-chevron-circle-up fa-lg"></i></div>
    <form action="/vacaciones/solicitar" method="POST" id="show" class="collapse"> 
      {{ csrf_field() }}
      <div class="form-row {{ $errors->has('dias') ? ' has-error' : '' }}">
        <label class="control-label" for="dias">Día(s) a solicitar:<span class="required">*</span></label>
        <input onkeydown="return false" class="datepicker" data-date-format="dd-mm-yyyy" name="dias" required>
        @if ($errors->has('dias'))
          <script>
            $(document).ready(function () {
              //If Collapsed then open
              openMenu();  
            });
          </script>  
          <span class="help-block formatted">
              <strong>{{ $errors->first('dias') }}</strong>
          </span>
        @endif
      </div>  
      <div class="form-row">
        <label for="manager">Manager:</label>
        <label name="manager" >{{$empleado->admin_nombre}} {{$empleado->admin_apellidos}}</label>
      </div>
      <div class="form-row">
        <label for="copia">Enviar copia a:</label>
        @foreach ($admins as $admin)
          @if($admin->cedula != $empleado->id_manager)
          <div class="checkbox">
            <label>
              <input name="copy" class="form-check-input" type="checkbox" value="{{$admin->cedula}}">{{$admin->nombre}} {{$admin->apellidos}}</input>
            </label>
          </div>
          @endif
        @endforeach
      </div>
      <div class="form-row">
        <button type="submit" class="btn btn-primary" @if ($availableDays == 0) disabled @endif>Solicitar</button>
      </div>
      <input name="empleado" type="hidden" value="{{$empleado->cedula}}">
      <input name="availableDays" type="hidden" value="{{$availableDays}}">
      <input name="adminName" type="hidden" value="{{$empleado->admin_nombre}} {{$empleado->admin_apellidos}}">
      <input name="adminEmail" type="hidden" value="{{$empleado->admin_email}}">
      <input name="employeeEmail" type="hidden" value="{{$empleado->email}}">
      <input name="employeeName" type="hidden" value="{{$empleado->nombre}} {{$empleado->apellidos}}">
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
        multidate: true,
        daysOfWeekDisabled: [0,6],
        language: 'es'
      });
    });

    $(".deleteVacation").on("submit", function(){
        return confirm("¿Desea eliminar esta solicitud de vacaciones?");
    });

    $(".edit-vacation").click(function(el){
      $('.datepicker').datepicker('remove');
      $('.datepicker').datepicker({
        startDate: '+1d',
        daysOfWeekDisabled: [0,6],
        language: 'es'
      });
      $.get("/vacaciones/modificar/"+el.target.value, function(result){
        //If Collapsed then open
        openMenu();
        $('.panel-heading span').text('Modificar solicitud');
        $('form#show button').text('Modificar');
        $('form#show').attr('action', '/vacaciones/modificar/'+ result.vacation.id);  
        //Fill Form
        $('input[name=dias]')[0].value = result.vacation.fecha;
      });
    });

  }, 100);
</script>  
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection