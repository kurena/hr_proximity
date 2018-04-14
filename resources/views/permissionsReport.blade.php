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
    <h3>Reporte de permisos</h3>
    <h3>Colaborador: {{$employee->nombre}} {{$employee->apellidos}}</h3>
  </div>
  </header>
  <section id="permissions-report-content">
    <div class="permissions-days">
      <h4>Permisos de ausencia</h4>
      <table class="table table-bordered" id="">
        <thead>
          <tr>
            <th scope="col">Día</th>
            <th scope="col">Cantidad de horas</th>
            <th scope="col">Reposición de horas</th>
            <th scope="col">Afectación en salario</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($days as $day)
          <tr>
            <td>{{$day->f_fecha}}</td>
            <td>{{ $day->cant_horas }}</td>
            <td>{{ $day->reposicion == 0 ? 'No' : 'Sí' }}</td>
            <td>{{ $day->reposicion > 0 ? 'N/A' : '₡'.$day->afectacion }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
<div>
@endsection