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
    <h3>Reporte de viático</h3>
    <h4>Empleado(a): {{$expense->nombre}} {{$expense->apellidos}}</h4>
  </div>
  </header>
  <section class="contracts-report">
    <div class="info-content">
      <h3>Informacion de viatico</h3>
      <ul class="list-group">
          <li class="list-group-item list-group-item-info">Tipo: {{ucfirst(trans($expense->tipo))}}</li>
          <li class="list-group-item list-group-item-info">Fecha ingreso: {{$expense->fecha}}</li>
          <li class="list-group-item list-group-item-info">Descripción: {{$expense->descripcion}}</li>
          <li class="list-group-item list-group-item-info">Total: ${{$expense->total}}</li>
      </ul>
    </div>
    <div class="detail-content">
      <h3>Comprobacion de viático</h3>
      <table class="table table-bordered" id="">
        <thead>
          <tr>
            <th scope="col">Fecha ingreso</th>
            <th scope="col">Tipo</th>
            <th scope="col">Descripción</th>
            <th scope="col">Monto</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($calculations as $calculation)
          <tr>
            <td class="list-group-item-info">{{$calculation->fecha_f}}</td>
            <td class="list-group-item-info">{{$calculation->tipo}}</td>
            <td class="list-group-item-info">{{$calculation->descripcion}}</td>
            <td class="list-group-item-info">${{$calculation->monto }}</td>
          </tr>
          @endforeach
          <tr>
            <td class="list-group-item-info"></td>
            <td class="list-group-item-info"></td>
            <td class="list-group-item-info"></td>
            <td class="list-group-item-info">Total: <strong>${{$total }}</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
<div>
@endsection
