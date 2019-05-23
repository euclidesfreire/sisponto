@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" type="text/css" href="css/login.css"> <!-- CSS PROVISÓRIO-->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
   <div class="container login-box">

            <div class="">
                <h1>{!! config('adminlte.logo', '<b>SIS</b>PONTO') !!}</h1>
                    
                <span>Use sua conta do Active Directory</span>
             </div>
            
            <div class="form-container sign-in-container">
                <form action="{{ url(config('adminlte.login_url', '/')) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <!--   type="email" -->
                            <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}"
                            placeholder="Usuário">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('usuario'))
                            <span class="help-block">
                                <strong>{{ $errors->first('usuario') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" class="form-control"
                            placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-right">
                        <img src="img/logo-jfma.png" alt="JFMA" height="110" width="312">
                        <h1>Bem vindo!</h1>
                        <p>Este é o Sistema de Gestão de Registros de Ponto da Justiça Federal do Maranhão - SIS Ponto.</p>
                        <button class="ghost" id="signUp">Contato</button>
                    </div>
                </div>
                
            </div>
        </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
