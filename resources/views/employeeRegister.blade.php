@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4>Ingrese los datos del empleado:</h4>
            <br>
            <form method="post" action="/empleado/registrar">
            {{ csrf_field() }}
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" placeholder="">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="user.test@proximitycr.com">
              </div>
              <div class="form-group col-md-6">
                <label for="cedula">Cedula</label>
                <input type="text" class="form-control" name="cedula" placeholder="123456789">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="direccion">Direccion</label>
                <input type="text" class="form-control" name="direccion" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="celular">Celular</label>
                <input type="text" class="form-control" name="celular" placeholder="12345678">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="puesto">Puesto</label>
                <input type="text" class="form-control" name="puesto" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="salario">Salario</label>
                <input type="number" class="form-control" name="salario" placeholder="">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fecha_ingreso">Fecha Ingreso</label>
                <input type="text" class="form-control" name="fecha_ingreso" placeholder="yyyy/mm/dd">
              </div>
              <div class="form-group col-md-6">
                <label for="fecha_nacimiento">Fecha Nacimiento</label>
                <input type="text" class="form-control" name="fecha_nacimiento" placeholder="yyyy/mm/dd">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="selectRol">Rol</label>
                <select class="form-control" name="selectRol">
                  <option value="administrador">Administrador</option>
                  <option value="empleado">Empleado</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="selectManager">Manager</label>
                <select class="form-control" name="selectManager">
                @foreach ($admins as $admin)
                  <option value="{{$admin->cedula}}">{{ $admin->nombre }} {{ $admin->apellidos }}</option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-20">
              <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            </div
            </form>
    </div>
</div>
@endsection