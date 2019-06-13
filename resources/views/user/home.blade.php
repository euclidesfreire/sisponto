@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
@stop

@section('content')
     @include('user.includes.formulario')

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Ent. 1</th>
                <th>Sai. 1</th>
                <th>Ent. 2</th>
                <th>Sai. 2</th>
                <th>Extra</th>
                <th>Debito</th>
                <th>Credito</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros['batidas'] as $batida)
            <tr class="@if($batida['entrada1'] === 'Folga' || $batida['entrada1'] === 'Feriado')
                        {{'warning'}}
                       @elseif($batida['entrada1'] === 'Falta')
                        {{'danger'}}
                       @endif">
                    <td>{{ $batida['data']}}</td>
                    <td>{{ $batida['entrada1']}}</td>
                    <td>{{ $batida['saida1']}}</td>
                    <td>{{ $batida['entrada2']}}</td>
                    <td>{{ $batida['saida2']}}</td>
                    <td>{{ $batida['extra']}}</td>
                    <td>{{ $batida['debito']}}</td>
                    <td>{{ $batida['credito']}}</td>
                    <td>{{ $batida['total']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop