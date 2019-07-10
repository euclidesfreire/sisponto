@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
@stop

@section('content')
    @include('manager.includes.formulario_calculo',  [ 'registros' => $registros])
    @include('geral.batidas.table', [ 'batidas' => $registros['batidas'], 'total' => $registros['total']])
@stop