@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Elija la opción que desea realizar</div>
                    @if(Auth::check())
                        @if($empleado->rol == 'administrador')
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Empleados <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Consultar</a></li>
                                <li><a href="/empleado/registrar">Registrar</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="">Registrar usuario</a></li>
                            </ul>
                        </div>
                        @endif
                        @if($empleado->rol == 'empleado')
                            <button>Consulta de datos</button>
                            <button>Vacaciones</button>
                            <button>Permisos</button>
                        @endif
                    @endif
                </div>
            @if(Auth::guest())
              <a href="/login" class="btn btn-info"> Tienes que iniciar sesión primero!</a>
            @endif
        </div>
    </div>
</div>
@endsection