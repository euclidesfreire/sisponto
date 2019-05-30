@extends('adminlte::page')

@section('title', 'SIS Ponto')

@section('content_header')
@stop

@section('content')
    @include('manager.includes.formulario_calculo')

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

@section('js')
   <!--  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="{{url('js/daterangepicker.min.js')}}"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{url('js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
    <script type="text/javascript" src="{{url('js/sisprint.js')}}"></script> -->
@stop