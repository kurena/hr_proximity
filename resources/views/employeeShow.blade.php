@extends('layouts.app')

@section('content')
<div class="container">
  
    <table id="example" class="display">
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
          </tr>
          @endforeach
      </tbody>
    </table>
</div>       
<script type="text/javascript" src="{{ asset('js/util.js') }}"></script>

@endsection