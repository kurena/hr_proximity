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
    <h3>Reporte de datos de empleado(a)</h3>
    <h3>Empleado(a): {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="employee-report-content">
    <ul class="list-group">
      <li class="list-group-item list-group-item-info">Cédula: {{$employee->cedula}}</li>
      <li class="list-group-item list-group-item-info">Email: {{$employee->email}}</li>
      <li class="list-group-item list-group-item-info">Dirección: {{$employee->direccion}}</li>
      <li class="list-group-item list-group-item-info">Celular: {{$employee->celular}}</li>
      <li class="list-group-item list-group-item-info">Puesto: {{$employee->puesto}}</li>
      <li class="list-group-item list-group-item-info">Salario: ₡{{$employee->salario}}</li>
      <li class="list-group-item list-group-item-info">Fecha nacimiento: {{$employee->fecha_nacimiento}}</li>
      <li class="list-group-item list-group-item-info">Fecha ingreso: {{$employee->fecha_ingreso}}</li>
    </ul>
  </section>
<div>
@endsection