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
    <h3>Reporte de liquidación de empleado(a)</h3>
    <h3>Empleado(a): {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="settle-report-content">
    <h4>Cálculo aproximado de la liquidación</h4>
    <table class="table table-bordered" id="">
      <thead>
        <tr>
          <th scope="col">Vacaciones</th>
          <th scope="col">Aguinaldo</th>
          @if ($type == "settle2")
          <th scope="col">Cesantía</th>
          <th scope="col">Preaviso</th>
          @endif
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="list-group-item-info">₡{{$vacations}}</td>
          <td class="list-group-item-info">₡{{$agui}}</td>
          @if ($type == "settle2")
          <td class="list-group-item-info">₡{{$ces}}</td>
          <td class="list-group-item-info">₡{{$pre}}</td>
          @endif
        </tr>
        <tr>
          <td class="list-group-item-info"></td>
          @if ($type == "settle2")
          <td class="list-group-item-info"></td>
          <td class="list-group-item-info"></td>
          @endif
          <td class="list-group-item-info">Total: <strong>₡{{$total}}</strong></td>
        </tr>
      </tbody>
    </table> 
  </section>
<div>
@endsection