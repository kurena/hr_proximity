@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Principal</a></li>
        <li class="breadcrumb-item active">Registrar usuario</li>
    </ol>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Registar usuario</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('cedula') ? ' has-error' : '' }}">
                            <label for="cedula" class="col-md-4 control-label">Empleado<span class="required">*</span></label>

                            <div class="col-md-6">
                                <select class="form-control" name="cedula">
                                    @foreach ($emps as $emp)
                                    <option value="{{$emp->cedula}}">{{ $emp->nombre }} {{ $emp->apellidos }}</option>
                                    @endforeach
                                    @if (count($emps) == 0) 
                                    <option>No existen empleados pendientes de creación de usuario</option>
                                        <script>
                                            $(document).ready(function() {
                                                $('input[name=nombre_usuario],input[name=contrasena],input[name=contrasena_confirmation],#register-user')
                                                .prop("disabled",true);
                                            });
                                        </script>
                                    @endif
                                </select>
                                @if ($errors->has('cedula'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cedula') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nombre_usuario') ? ' has-error' : '' }}">
                            <label for="nombre_usuario" class="col-md-4 control-label">Nombre Usuario<span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="nombre_usuario" type="text" class="form-control" name="nombre_usuario" value="{{ old('nombre_usuario') }}" required>

                                @if ($errors->has('nombre_usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contrasena') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña<span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="contrasena" required>

                                @if ($errors->has('contrasena'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contrasena') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contrasena-confirm" class="col-md-4 control-label">Confirmar Contraseña<span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="contrasena-confirm" type="password" class="form-control" name="contrasena_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="register-user">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
