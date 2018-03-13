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
                  <label for="nombre">Nombre<span class="required">*</span></label>
                  <input type="text" class="form-control" name="nombre" placeholder="" required>
                  @if ($errors->has('nombre'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nombre') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="apellidos">Apellidos<span class="required">*</span></label>
                  <input type="text" class="form-control" name="apellidos" placeholder="" required>
                  @if ($errors->has('apellidos'))
                    <span class="help-block">
                        <strong>{{ $errors->first('apellidos') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">Email<span class="required">*</span></label>
                  <input type="email" class="form-control" name="email" placeholder="user.test@proximitycr.com" required>
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="cedula">Cedula<span class="required">*</span></label>
                  <input type="text" class="form-control" name="cedula" placeholder="123456789" required>
                  @if ($errors->has('cedula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cedula') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="direccion">Direccion<span class="required">*</span></label>
                  <input type="text" class="form-control" name="direccion" placeholder="" required>
                  @if ($errors->has('direccion'))
                    <span class="help-block">
                        <strong>{{ $errors->first('direccion') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="celular">Celular<span class="required">*</span></label>
                  <input type="text" class="form-control" name="celular" placeholder="12345678" required>
                  @if ($errors->has('celular'))
                    <span class="help-block">
                        <strong>{{ $errors->first('celular') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="puesto">Puesto<span class="required">*</span></label>
                  <input type="text" class="form-control" name="puesto" placeholder="" required>
                  @if ($errors->has('puesto'))
                    <span class="help-block">
                        <strong>{{ $errors->first('puesto') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="salario">Salario<span class="required">*</span></label>
                  <input type="number" class="form-control" name="salario" placeholder="" required>
                  @if ($errors->has('salario'))
                    <span class="help-block">
                        <strong>{{ $errors->first('salario') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="fecha_ingreso">Fecha Ingreso<span class="required">*</span></label>
                  <input type="text" class="form-control" name="fecha_ingreso" placeholder="yyyy/mm/dd" required>
                  @if ($errors->has('fecha_ingreso'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fecha_ingreso') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="fecha_nacimiento">Fecha Nacimiento<span class="required">*</span></label>
                  <input type="text" class="form-control" name="fecha_nacimiento" placeholder="yyyy/mm/dd" required>
                  @if ($errors->has('fecha_nacimiento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                    </span>
                  @endif
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