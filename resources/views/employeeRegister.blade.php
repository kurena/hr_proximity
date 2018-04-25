@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Principal</a></li>
      @if ($editView and !$uniqueView)
      <li class="breadcrumb-item"><a href="/empleado/consultar">Consultar Empleados</a></li>
      <li class="breadcrumb-item active">Editar empleado(a)</li>
      @elseif ($editView and $uniqueView)
      <li class="breadcrumb-item active">Consultar datos empleado(a)</li>  
      @else
      <li class="breadcrumb-item active">Registrar empleado(a)</li>
      @endif
    </ol>
    <div class="row">
        <div class="register-form col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
              @if ($editView and !$uniqueView)
              <div class="panel-heading">Ingrese los datos del colaborador que desea actualizar</div>
              @elseif ($editView and $uniqueView)
              <div class="panel-heading">Datos del colaborador</div>
              @else
              <div class="panel-heading">Ingrese los datos del colaborador</div>
              @endif
              <form method="post" action="/empleado/{{$editView ? 'editar/'.$empleado->cedula : 'registrar'}}">
                {{ csrf_field() }}
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('nombre') ? ' has-error' : '' }}">
                    <label class="control-label" for="nombre">Nombre<span class="required">*</span></label>
                    <input type="text" class="form-control" name="nombre" placeholder="" 
                    required value="{{$editView ? $empleado->nombre: old('nombre')}}">
                    @if ($errors->has('nombre'))
                      <span class="help-block">
                          <strong>{{ $errors->first('nombre') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('apellidos') ? ' has-error' : '' }}">
                    <label class="control-label" for="apellidos">Apellidos<span class="required">*</span></label>
                    <input type="text" class="form-control" name="apellidos" placeholder="" 
                    required value="{{$editView ? $empleado->apellidos : old('apellidos')}}">
                    @if ($errors->has('apellidos'))
                      <span class="help-block">
                          <strong>{{ $errors->first('apellidos') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label" for="email">Email<span class="required">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="nombre.apellido@proximitycr.com" required value="{{$editView ? $empleado->email : old('email')}}" @if($uniqueView) disabled @endif>
                    @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('cedula') ? ' has-error' : '' }}">
                    <label class="control-label" for="cedula">Cédula<span class="required">*</span></label>
                    <input type="text" class="form-control" name="cedula" placeholder="123456789" required value="{{$editView ? $empleado->cedula : old('cedula')}}">
                    @if ($errors->has('cedula'))
                      <span class="help-block">
                          <strong>{{ $errors->first('cedula') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('direccion') ? ' has-error' : '' }}">
                    <label class="control-label" for="direccion">Dirección<span class="required">*</span></label>
                    <input type="text" class="form-control" name="direccion" placeholder="" required value="{{$editView ? $empleado->direccion : old('direccion')}}">
                    @if ($errors->has('direccion'))
                      <span class="help-block">
                          <strong>{{ $errors->first('direccion') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6{{ $errors->has('celular') ? ' has-error' : '' }} ">
                    <label class="control-label" for="celular">Celular<span class="required">*</span></label>
                    <input type="text" class="form-control" name="celular" placeholder="12345678" required value="{{$editView ? $empleado->celular : old('celular')}}">
                    @if ($errors->has('celular'))
                      <span class="help-block">
                          <strong>{{ $errors->first('celular') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('puesto') ? ' has-error' : '' }}">
                    <label class="control-label" for="puesto">Puesto<span class="required">*</span></label>
                    <input type="text" class="form-control" name="puesto" placeholder="" required value="{{$editView ? $empleado->puesto : old('puesto')}}" @if($uniqueView) disabled @endif>
                    @if ($errors->has('puesto'))
                      <span class="help-block">
                          <strong>{{ $errors->first('puesto') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('salario') ? ' has-error' : '' }}">
                    <label class="control-label" for="salario">Salario<span class="required">*</span></label>
                    <input type="number" class="form-control" name="salario" placeholder="" required value="{{$editView ? $empleado->salario : old('salario')}}" @if($uniqueView) disabled @endif>
                    @if ($errors->has('salario'))
                      <span class="help-block">
                          <strong>{{ $errors->first('salario') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('fecha_ingreso') ? ' has-error' : '' }}">
                    <label class="control-label" for="fecha_ingreso">Fecha ingreso<span class="required">*</span></label>
                    <input onkeydown="return false" class=" form-control datepicker" data-date-format="dd-mm-yyyy" name="fecha_ingreso" placeholder="dd-mm-yyyy" value="{{$editView ? $empleado->fecha_ingreso : old('fecha_ingreso')}}" @if($uniqueView) disabled @endif>  
                    @if ($errors->has('fecha_ingreso'))
                      <span class="help-block">
                          <strong>{{ $errors->first('fecha_ingreso') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                    <label class="control-label" for="fecha_nacimiento">Fecha nacimiento<span class="required">*</span></label>
                    <input onkeydown="return false" class=" form-control datepicker" data-date-format="dd-mm-yyyy" name="fecha_nacimiento" placeholder="dd-mm-yyyy" value="{{$editView ? $empleado->fecha_nacimiento : old('fecha_nacimiento')}}">
                    @if ($errors->has('fecha_nacimiento'))
                      <span class="help-block">
                          <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                  @if(!$uniqueView) 
                    <label for="selectRol">Rol</label>
                    <select class="form-control" name="selectRol">
                      <option value="administrador" {{$editView && $empleado->rol=='administrador' ? 'selected' : ''}}>Administrador</option>
                      <option value="empleado" {{$editView && $empleado->rol=='empleado' ? 'selected' : ''}}>Empleado</option>
                    </select>
                  @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="selectManager">Manager</label>
                    <select class="form-control" name="selectManager" @if($uniqueView) disabled @endif>
                    @foreach ($admins as $admin)
                      <option value="{{$admin->cedula}}" {{$editView && $admin->cedula == $empleado->id_manager ? 'selected' : ''}}>{{ $admin->nombre }} {{ $admin->apellidos }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                @if ($editView)
                <div class="form-row">
                  <div class="form-group col-md-6 {{ $errors->has('usuario') ? ' has-error' : '' }}">
                    <label class="control-label" for="puesto">Nombre usuario<span class="required">*</span></label>
                    <input type="text" class="form-control" name="usuario" placeholder="nombre.apellido" required value="{{$editView ? $empleado->nombre_usuario : ''}}" @if($uniqueView) disabled @endif>
                    @if ($errors->has('usuario'))
                      <span class="help-block">
                          <strong>{{ $errors->first('usuario') }}</strong>
                      </span>
                    @endif
                  </div>
                  <input name="userId" type="hidden" value="{{$empleado->usuario_id}}">
                </div>
                @endif
                <div class="form-row">
                  <div class="text-center col-md-20">
                    <button type="submit" class="btn btn-primary">{{$editView ? 'Actualizar' : 'Registrar'}}</button>
                    <input name="view" type="hidden" value="{{$uniqueView}}">
                  </div>
                </div
              </form>
          </div>
        </div>  
    </div>
</div>
<script>
  setTimeout(() => {
    $(document).ready(function () {
      $('.datepicker').datepicker({
        endDate: '0d',
        language: 'es'
      });
    });
  }, 100);
</script>
@endsection