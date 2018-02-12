@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Dashboard</div>

                    @if(Auth::check())
                      <div>
                        Bienvenido a HR Proximity!
                      </div>  
                    @endif


            </div>
            @if(Auth::guest())
              <a href="/login" class="btn btn-info"> Tienes que iniciar sesión primero!</a>
            @endif
        </div>
    </div>
</div>
@endsection