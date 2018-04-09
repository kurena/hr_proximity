@extends('layouts.reports')

@section('content')
<div id="report">
  <header>
  <div class="head-first">  
    <button type="button" class="hide-print btn btn-primary" onclick="location.href='/reportes'">Reportes</button>
    <button type="button" class="hide-print btn btn-primary" onclick="window.print();">Imprimir</button>
    <h5>Generado por: {{$reporter->nombre}} {{$reporter->apellidos}}</h5>
    <span>{{$creationDate}}</span>
  </div>
  <div class="head-second">  
    <h3>Reporte de datos de colaborador</h3>
    <h3>Colaborador: {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="employee-report-content">
    <ul class="list-group">
      <li class="list-group-item">Cédula: {{$employee->cedula}}</li>
      <li class="list-group-item">Email: {{$employee->email}}</li>
      <li class="list-group-item">Dirección: {{$employee->direccion}}</li>
      <li class="list-group-item">Celular: {{$employee->celular}}</li>
      <li class="list-group-item">Puesto: {{$employee->puesto}}</li>
      <li class="list-group-item">Salario: ₡{{$employee->salario}}</li>
      <li class="list-group-item">Fecha nacimiento: {{$employee->fecha_nacimiento}}</li>
      <li class="list-group-item">Fecha ingreso: {{$employee->fecha_ingreso}}</li>
    </ul>
  </section>
<div>
@endsection