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
  <div class="expenses-requested">
    <h4>Viáticos</h4>
    <table class="table table-bordered" id="requestedPermissions">
      <thead>
        <tr>
          <th scope="col">Fecha ingreso</th>
          <th scope="col">Tipo</th>
          <th scope="col">Descripción</th>
          <th scope="col">Monto total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr class="success">
          <td>{{$expense->fecha}}</td>
          <td>{{ucfirst(trans($expense->tipo))}}</td>
          <td>{{$expense->descripcion}}</td>
          <td>${{$expense->total}}</td>
          <td>
            <form action="/viaticos/comprobacion/{{$expense->id}}" method="post">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-primary">Consultar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection