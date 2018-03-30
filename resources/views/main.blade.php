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
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Elija la opción que desea realizar</div>
                    @if(Auth::check())
                        @if($empleado->rol == 'administrador')
                        <div class="row">
                            <div class="btn-group-vertical col-md-4 col-md-offset-4" role="group">
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Empleados <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/empleado/consultar">Consultar</a></li>
                                        <li><a href="/empleado/registrar">Registrar</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="/register">Registrar usuario</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Vacaciones <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/vacaciones/aprobar">Aprobar</a></li>
                                        <li><a href="/vacaciones">Solicitar</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Permisos <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/permisos/aprobar">Aprobar</a></li>
                                        <li><a href="/permisos">Solicitar</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Incapacidades <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/incapacidades">Ingresar</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Dashboard de contratos <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Consultar</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-lg btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Viaticos <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Consultar</a></li>
                                    </ul>
                                </div>
                            </div> 
                        </div>
                        <div class="admin-alerts alert alert-warning">
                            <h5>Alertas</h5>
                            @if ($vacaciones > 0) 
                                @if ($vacaciones == 1)
                                    <a href="/vacaciones/aprobar">1 solicitud de vacaciones pendiente de aprobación</a>
                                @else
                                <a href="/vacaciones/aprobar">{{ $vacaciones }} solicitudes de vacaciones pendientes de aprobación</a>
                                @endif
                            @elseif ($permisos > 0) 
                                @if ($permisos == 1)
                                    <a href="/permisos/aprobar">1 solicitud de permiso pendiente de aprobación</a>
                                @else
                                <a href="/permisos/aprobar">{{ $vacaciones }} solicitudes de permiso pendientes de aprobación</a>
                                @endif    
                            @else
                                No existen alertas por el momento.    
                            @endif
                        </div>
                        @endif
                        @if($empleado->rol == 'empleado')
                        <div class="row">
                            <div class="btn-group-vertical col-md-4 col-md-offset-4" role="group">
                                <br>
                                <button type="button" class="btn-lg btn btn-primary" onclick="location.href = '/empleado/consultar/{{$empleado->cedula}}';">Consulta de datos</button>
                                <br>
                                <button type="button" class="btn-lg btn btn-primary" onclick="location.href = '/vacaciones'">Vacaciones</button>
                                <br>
                                <button type="button" class="btn-lg btn btn-primary" onclick="location.href = '/permisos'">Permisos</button>
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
</div>
@endsection