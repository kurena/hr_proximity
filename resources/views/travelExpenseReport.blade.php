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
    <h3>Reporte de viatico</h3>
    <h4>Empleado(a): {{$expense->nombre}} {{$expense->apellidos}}</h4>
  </div>
  </header>
  <section class="contracts-report">
    <div class="info-content">
      <h3>Informacion de viatico</h3>
      <ul class="list-group">
          <li class="list-group-item">Tipo: {{ucfirst(trans($expense->tipo))}}</li>
          <li class="list-group-item">Fecha ingreso: {{$expense->fecha}}</li>
          <li class="list-group-item">Descripcion: {{$expense->descripcion}}</li>
          <li class="list-group-item">Total: ${{$expense->total}}</li>
      </ul>
    </div>
    <div class="detail-content">
      <h3>Comprobacion de viatico</h3>
      <table class="table table-bordered" id="">
        <thead>
          <tr>
            <th scope="col">Fecha ingreso</th>
            <th scope="col">Tipo</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Monto</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($calculations as $calculation)
          <tr>
            <td>{{$calculation->fecha_f}}</td>
            <td>{{$calculation->tipo}}</td>
            <td>{{$calculation->descripcion}}</td>
            <td>${{$calculation->monto }}</td>
          </tr>
          @endforeach
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total: <strong>${{$total }}</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
<div>
@endsection
