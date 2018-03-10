@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Elija la opción que desea realizar</div>
                    @if(Auth::check())
                        @if($empleado->rol == 'administrador')
                          <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown button
                                </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                              </div>
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