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
    <h3>Reporte de contrato</h3>
    <h4>{{$contract->nombre_contrato}}</h4>
  </div>
  </header>
  <section class="contracts-report">
    <div class="info-content">
      <h3>Informacion de contrato</h3>
      <ul class="list-group">
          <li class="list-group-item">Empleado asignado: {{$contract->nombre}} {{$contract->apellidos}}</li>
          <li class="list-group-item">Fecha inicio: {{$contract->fecha_inicio}}</li>
          <li class="list-group-item">Fecha fin: {{$contract->fecha_fin == null ? 'N/A': $contract->fecha_fin}}</li>
          <li class="list-group-item">Tipo: {{ucfirst(trans($contract->tipo))}}</li>
          <li class="list-group-item">Forma pago: {{ucfirst(trans($contract->forma_pago))}}</li>
          <li class="list-group-item">Monto: ${{$contract->monto}}</li>
      </ul>
    </div>
    <div class="detail-content">
      <h3>Comprobacion de pagos</h3>
      <table class="table table-bordered" id="">
        <thead>
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Monto</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($calculations as $calculation)
          <tr>
            <td>{{$calculation->fecha_f}}</td>
            <td>${{$calculation->monto }}</td>
          </tr>
          @endforeach
          <tr>
            <td></td>
            <td>Total: <strong>${{$total }}</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
<div>
@endsection
