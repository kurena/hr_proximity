@extends('layouts.app')

@section('content')
@if (session('status'))
  <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{ session('status') }}
  </div>
@endif 
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Consultar Empleados</li>
  </ol>
  <h3>Consulta de empleados:</h3>
  <table id="employeeData" class="display nowrap">
    <thead>
        <tr>
            <th>Acciones</th>
            <th>Cédula</th>
            <th>Empleado(a)</th>
            <th>Email</th>
            <th>Fecha ingreso</th>
            <th>Puesto</th>
            <th>Manager</th>
            <th>Rol</th>
            <th>Salario</th>
            <th>Direccion</th>
            <th>Fecha nacimiento</th>
            <th>Celular</th>
            <th>Nombre usuario</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $emp)
        <tr>
            <td>
              <form action="/empleado/eliminar/{{$emp->cedula}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" >
                <button type="submit" class="btn btn-primary">Eliminar</button>
              </form>
              <br>
              <form action="/empleado/editar/{{$emp->cedula}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="GET" >
                <button type="submit" class="btn btn-primary">Editar</button>
              </form>
            </td>
            <td>{{$emp->cedula}}</td>
            <td>{{$emp->nombre}} {{$emp->apellidos}}</td>
            <td>{{$emp->email}}</td>
            <td>{{$emp->fecha_ingreso}}</td>
            <td>{{$emp->puesto}}</td>
            <td>{{$emp->admin_nombre}} {{$emp->admin_apellidos}}</td>
            <td>{{ucfirst(trans($emp->rol))}}</td>
            <td>{{$emp->salario}}</td>
            <td>{{$emp->direccion}}</td>
            <td>{{$emp->fecha_nacimiento}}</td>
            <td>{{$emp->celular}}</td>
            <td>{{$emp->nombre_usuario}}</td>
        </tr>
        @endforeach
    </tbody>
  </table> 
</div>       
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>

@endsection