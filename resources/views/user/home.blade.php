@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
    <div class="col-md-6">
       <span>Servidor</span>
       <h4>{{Auth::user()->nome}}</h4>
    </div>
    <div class="col-md-6">
    	<span>Departamento</span>
        <h4></h4>
    </div>
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Ent. 1</th>
                <th>Sai. 1</th>
                <th>Ent. 2</th>
                <th>Sai. 2</th>
                <th>Debito</th>
                <th>Credito</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros['batidas'] as $batida)
            <tr>
                    <td>{{ $batida->data }}</td>
                    <td>{{ $batida->entrada1}}</td>
                    <td>{{ $batida->saida1}}</td>
                    <td>{{ $batida->entrada2}}</td>
                    <td>{{ $batida->saida2}}</td>
                    <td>{{ $batida->debito}}</td>
                    <td>{{ $batida->credito}}</td>
                    <td>{{ $batida->total}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop