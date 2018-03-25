@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Elija la opción que desea realizar</div>
                    @if(Auth::check())
                        @if($empleado->rol == 'administrador')
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Empleados <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/empleado/consultar">Consultar</a></li>
                                <li><a href="/empleado/registrar">Registrar</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/register">Registrar usuario</a></li>
                            </ul>
                        </div>
                        @endif
                        @if($empleado->rol == 'empleado')
                        <div class="row">
                            <div class="btn-group-vertical col-md-4 col-md-offset-4" role="group">
                                <br>
                                <button type="button" class="btn-lg btn btn-primary" onclick="location.href = '/empleado/consultar/{{$empleado->cedula}}';">Consulta de datos</button>
                                <br>
                                <button type="button" class="btn-lg btn btn-primary">Vacaciones</button>
                                <br>
                                <button type="button" class="btn-lg btn btn-primary">Permisos</button>
                                <br>
                            </div>
                        </div>
                        
                        @endif
                    @endif
                </div>
            @if(Auth::guest())
              <a href="/login" class="btn btn-info"> Tienes que iniciar sesión primero!</a>
            @endif
        </div>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection