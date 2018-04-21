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
    <h3>Reporte de incapacidades</h3>
    <h3>Colaborador: {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="incapacity-report-content">
    <div class="incapacity-days">
      <h4>Incapacidad(es) ingresadas</h4>
      <table class="table table-bordered" id="">
        <thead>
          <tr>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Fecha fin</th>
            <th scope="col">Afectaciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($days as $day)
          <tr>
            <td>{{$day->f_fecha_i}}</td>
            <td>{{$day->f_fecha_f}}</td>
            <td>
                <strong>Primeros tres dias:</strong><br>
                Proximity CR:₡{{$day->afectacionPatrono}} por dia / CCSS:₡{{$day->afectacionCCSS1}} por dia<br>
                <strong>Cuarto dia en adelante:</strong><br>
                CCSS:₡{{$day->afectacionCCSS2}} por dia
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
<div>
@endsection
