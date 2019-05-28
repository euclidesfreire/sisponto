@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
      <div class="col-md-6">
        <span>Servidor</span>
        <h4>{{Auth::user()->nome}}</h4>
    </div>
    <div class="col-md-6">
        <span>Departamento</span>
        <h4>{{$departamento->descricao}}</h4>
    </div>
@stop

@section('content')
    <p>You are logged in!</p>
@stop