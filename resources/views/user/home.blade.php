@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
@stop

@section('content')
     @include('user.includes.formulario')
     @include('geral.batidas.table', [ 'batidas' => $registros['batidas']])
@stop