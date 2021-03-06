@extends('layouts.reports')

@section('content')
<div id="report">
  <header>
  <div class="head-first">  
    <img class="report-logo" src="/images/main-logo.png"> 
    <button type="button" class="hide-print btn btn-primary" onclick="location.href='/reportes'">Reportes</button>
    <button type="button" class="hide-print btn btn-primary" onclick="window.print();">Imprimir</button>
    <h5>Generado el: {{$creationDate}}</h5>
    <h6>por: {{$reporter->nombre}} {{$reporter->apellidos}}</h6>
  </div>
  <div class="head-second">  
    <h3>Reporte de vacaciones</h3>
    <h3>Empleado(a): {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="vacations-report-content">
    <div class="report-days">
      <h4>Días de vacaciones disfrutados</h4>
      <ul class="list-group">
        @foreach ($days as $day) 
          <li class="list-group-item list-group-item-info">{{$day->f_fecha}}</li>
        @endforeach
      </ul>
    </div>
    <div class="report-details">
      <h4>Días de vacaciones disponibles: <strong>{{$availableDays}}</strong></h4>
      <h4>Desgloce días disponibles por períodos</h4>
      @foreach ($periods as $period)
        <span>Del {{$period["start"]}} al {{$period["end"]}}: <strong>{{$period["days"]}}</strong> dia(s) disponibles</span>
        <br>
      @endforeach
    </div>  
  </section>
<div>
@endsection