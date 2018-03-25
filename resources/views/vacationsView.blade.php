@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Principal</a></li>
    <li class="breadcrumb-item active">Vacaciones</li>
  </ol>
  <h3>Días disponibles de vacaciones: <span class="label label-info">{{$availableDays}}</span></h3>
  
  
</div>       
@endsection