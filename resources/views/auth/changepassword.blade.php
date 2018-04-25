@extends('layouts.app')
 
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Principal</a></li>
        <li class="breadcrumb-item active">Cambiar contraseña</li>
    </ol>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Cambiar contraseña</div>
 
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    <form class="form-horizontal" method="POST" action="/cambiarContrasena">
                        {{ csrf_field() }}
 
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="nueva-contraseña" class="col-md-4 control-label">Contraseña actual<span class="required">*</span></label>
 
                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current-password" required>
 
                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 
                        <div class="form-group{{ $errors->has('nueva_contraseña') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">Nueva contraseña<span class="required">*</span></label>
 
                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="nueva_contraseña" required>
 
                                @if ($errors->has('nueva_contraseña'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nueva_contraseña') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label for="new-password-confirm" class="col-md-4 control-label">Confirmar contraseña<span class="required">*</span></label>
 
                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control" name="nueva_contraseña_confirmation" required>
                            </div>
                        </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Cambiar contraseña
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