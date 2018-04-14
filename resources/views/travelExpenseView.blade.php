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
    <li class="breadcrumb-item active">Viáticos</li>
  </ol>
  <div class="permissions-requested">
    <h4>Viáticos</h4>
    <table class="table table-bordered" id="travel-expense">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Fecha ingreso</th>
          <th scope="col">Tipo</th>
          <th scope="col">Colaborador</th>
          <th scope="col">Monto total</th>
          <th scope="col">Descripción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr class="success">
          <td>
            <form action="/viaticos/comprobacion/{{$expense->id}}" method="get">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="GET" >
              <button type="submit" class="btn btn-primary">Comprobación</button>
            </form>
          </td>
          <td>{{$expense->fecha}}</td>
          <td>{{$expense->tipo}}</td>
          <td>{{$expense->nombre}} {{$expense->apellidos}}</td>
          <td>${{$expense->total}}</td>
          <td>{{$expense->descripcion}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel panel-info permissions-request">
    <div class="panel-heading">Ingresar nuevo viático</div>
    <form action="/viaticos/ingresar" method="POST">
      {{ csrf_field() }}
      <div class="form-row">
        <label for="dia">Tipo:<span class="required">*</span></label>
        <select class="form-control formatted" name="selectType">
          <option value="viaje">Viaje</option>
          <option value="otro">Otro</option>
        </select>
      </div>
      <div class="form-row">
          <label for="selectEmployee">Colaborador:<span class="required">*</span></label>
          <select class="form-control formatted" name="selectEmployee">
          @foreach ($employees as $employee)
            <option value="{{$employee->cedula}}">{{ $employee->nombre }} {{ $employee->apellidos }}</option>
          @endforeach
          </select>
      </div>
      <div class="form-row">
        <label for="comentarios">Descripción:<span class="required">*</span></label>
        <textarea class="formatted" name="descripcion" required></textarea>
      </div>
      <div class="form-row">
        <label for="monto">Monto en $:<span class="required">*</span></label>
        <input class="formatted" name="monto" type="number" min="0" required>
      </div>
      <div class="form-row">
        <div class="col-md-20 text-center"> 
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>  
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
@endsection