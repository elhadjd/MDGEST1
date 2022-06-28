<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/csss/app.css">
    <link rel="stylesheet" href="/csss/layouts.css">
    <link rel="icon" type="image/png" href="/storage/logo/log.png"/>
    <link rel="stylesheet" href="/csss/configuarcoes/config.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('Ponto de venda')</title>
</head>
<body>
    @extends('layotus.footer')
    @section('sidebar')
        <div id="nav_da_home_compra" class="position-fixed zindex-1080 w-100 top-0">
            <div class="botao"><i class="fa fa-th-large" aria-hidden="true"></i></div>
            <nav>
                <ul class="d-flex">
                    <li id="usuarios_liste"><strong>Home</strong></li>
                    <li id="empresa"><strong>Painel</strong></li>
                    <li class="float-right" id="user_conectado" value=" {{$user->id}} ">{{$user->apelido}}</li>
                </ul>
            </nav>
        </div>
        <script src="{{asset('js/app.js')}}" defer></script>
    @show
    @yield('header')
    @extends('layouts.MenuApp')
    <script type="text/javascript" src="csss/jquery.min.js"></script>
    <script src="/csss/configuarcoes/config.js"></script>
