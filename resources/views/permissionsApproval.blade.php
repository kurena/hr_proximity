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
    <li class="breadcrumb-item active">Aprobar permisos</li>
  </ol>
  <div class="permissions-requested">
    <h4>Permisos pendientes de aprobación</h4>
    <form action="/permisos/actualizarestado" method="POST">  
    {{ csrf_field() }}
      <table class="table table-bordered" id="requestedVacations">
        <thead>
          <tr>
            <th scope="col">Día</th>
            <th scope="col">Colaborador</th>
            <th scope="col">Cantidad horas</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Aprobar</th>
            <th scope="col">No aprobar</th>
            <th scope="col">Mantener pendiente</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($requestedDays as $day)
          <tr class="warning">
            <td>{{$day->fecha}}</td>
            <td>{{$day->nombre}} {{$day->apellidos}}</td>
            <td>{{$day->cant_horas}}</td>
            <td>{{$day->comentarios}}</td>
            <td>
              <div class="form-check">
                <input class="form-check-input" name="group{{$day->id}}" type="radio" value="aprobado">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input class="form-check-input" name="group{{$day->id}}" type="radio" value="no aprobado">
              </div>
            </td>
            <td>
              <div class="form-check">
                <input checked class="form-check-input" name="group{{$day->id}}" type="radio" value="pendiente">
              </div>
            </td>
            <input type="hidden" value="{{$day->id}}" name="id[]">
          </tr>
          @endforeach
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary" @if (count($requestedDays) == 0) disabled @endif>Actualizar estado</button>
    </form>
  </div>
  <div class="permissions-approved">
    <h4>Permisos aprobados/no aprobados</h4>
    <table class="table table-bordered" id="approvedVacations">
      <thead>
        <tr>
          <th scope="col">Día</th>
          <th scope="col">Colaborador</th>
          <th scope="col">Cantidad horas</th>
          <th scope="col">Comentarios</th>
          <th scope="col">Reposición de horas</th>
          <th scope="col">Afectación en salario</th>
          <th scope="col">Estado</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($approvedDays as $day)
        <tr class="{{ $day->estado=='aprobado' ? 'success' : 'danger'}}">
          <td>{{$day->fecha}}</td>
          <td>{{$day->nombre}} {{$day->apellidos}}</td>
          <td>{{$day->cant_horas}}</td>
          <td>{{$day->comentarios}}</td>
          <td>{{ $day->reposicion == 0 ? 'No' : 'Sí' }}</td>
          <td>{{ $day->reposicion > 0 ? 'N/A' : '₡'.$day->afectacion }}</td>
          <td>{{ ucfirst(trans($day->estado))}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> 
@endsection