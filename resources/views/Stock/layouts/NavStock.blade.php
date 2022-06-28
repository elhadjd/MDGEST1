<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/csss/app.css">
    <link rel="stylesheet" href="/csss/layouts.css">
    <link rel="stylesheet" href="/csss/Stock/Stock.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('Ponto de venda')</title>
</head>
<body>
    @section('sidebar')
        <div id="nav_da_home_compra" class="position-fixed user-select-none w-100 top-0">
            <div class="botao"><i class="fa fa-th-large" aria-hidden="true"></i></div>
            <nav>
                <ul class="d-flex">
                    <i class="bi bi-alarm"> </i>
                    <li id="home"><strong>Home</strong></li>
                    <li id="menu_ponto_principal">Stock</li>
                    <li id="Armagens">Armagens</li>
                    {{-- A iniciar a div relatorio --}}
                    <div>
                        <li id="relatorioPtVenda">Relatorios</li>
                        <div class="form-control position-absolute text-secondary shadow w-5 ListRelatorios">
                            <div class="Relatorios">Muvementos</div>
                            <div class="Relatorios">Transferencias</div>

                        </div>
                    </div>
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
    <script src="csss/Stock/Stock.js"></script>
