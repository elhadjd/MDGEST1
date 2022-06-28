<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/csss/app.css">
    <link rel="stylesheet" href="/csss/layouts.css">
    <link rel="icon" type="image/png" href="/storage/logo/log.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','Meu titlo')</title>
</head>
<body>
    @section('sidebar')
        <div id="nav_da_home_compra" class="position-fixed w-100 top-0">
            <nav>
                <ul class="d-flex">
                    <i class="bi bi-alarm"> </i>
                    <li id="home"><strong>Home</strong></li>
                    <li id="lista_das_compra">Lista de compras</li>
                    <li id="fornecedores_compra">Fornecedores</li>
                    <li id="pagamentos_compras">Pagamentos</li>
                    <li id="relatorio_compras">Relatorio</li>
                    <li id="lista_de_artigos" app="compra">Artigos</li>
                    <div class="float-right" id="user_conectado" value=" {{$user->id}} ">
                        <li class="Use">{{$user->apelido}}</li>
                        <div class="bg-white border rounded Usuario">
                            <div class="Sair">Sair  <i class="fa fa-sign-out"></i></div>
                        </div>
                    </div>
                </ul>
            </nav>
        </div>

    @show
    @yield('header')
