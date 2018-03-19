@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Consultar Empleados</li>
  </ol>
  <h3>Consulta de empleados:</h3>
  <table id="employeeData" class="display">
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Empleado</th>
            <th>Email</th>
            <th>Fecha Ingreso</th>
            <th>Puesto</th>
            <th>Rol</th>
            <th>Salario</th>
            <th>Manager</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $emp)
        <tr>
            <td>{{$emp->cedula}}</td>
            <td>{{$emp->nombre}} {{$emp->apellidos}}</td>
            <td>{{$emp->email}}</td>
            <td>{{$emp->fecha_ingreso}}</td>
            <td>{{$emp->puesto}}</td>
            <td>{{$emp->rol}}</td>
            <td>{{$emp->salario}}</td>
            <td>{{$emp->admin_nombre}} {{$emp->admin_apellidos}}</td>
            <td>
            <form action="/empleado/eliminar/{{$emp->cedula}}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="DELETE" >
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif  
</div>       
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>

@endsection