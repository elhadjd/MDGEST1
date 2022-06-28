<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/csss/app.css">
    <link rel="stylesheet" href="/csss/layouts.css">
    <link rel="stylesheet" href="/csss/Pos/pos.css">
    <link rel="icon" type="image/png" href="/storage/logo/log.png"/>
    <link rel="stylesheet" href="/csss/ponto_de_venda/ponto_de_venda.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('Ponto de venda')</title>
</head>
<body>
    @section('sidebar')
        <div id="nav_da_home_compra" class="position-fixed zindex-1080 user-select-none w-100 top-0">
            <div class="botao"><i class="fa fa-th-large" aria-hidden="true"></i></div>
            <nav>
                <ul class="d-flex">
                    <i class="bi bi-alarm"> </i>
                    <li id="home"><strong>Home</strong></li>
                    <li id="menu_ponto_principal">Ponto de venda</li>
                    <li id="pagamentos_compras">Pagamentos</li>
                    {{-- A iniciar a div relatorio --}}
                    <div>
                        <li id="relatorioPtVenda">Relatorio</li>
                        <div class="form-control position-absolute text-secondary shadow w-5 ListRelatorios">
                            <div class="Relatorios">Orden de venda</div>
                            <div class="Relatorios">Relatorio</div>
                            <div class="Relatorios">Gastos</div>
                            <div class="Relatorios">Avaliaçao de stock</div>
                        </div>
                    </div>
                    <li id="lista_de_artigos" app="compra">Artigos</li>
                    <div class="float-right d-flex" id="user_conectado" value=" {{$user->id}}">
                        <div class="alerta mx-4 shadow-lg"></div>
                        <div class="menssagensChat">
                            <div class="VenUserMenssagen mt-2">
                                <span class="novasMenssagens"></span>
                                <i class="fa fa-comments-o text-white icone" aria-hidden="true"></i>
                            </div>
                            <div class="ResultadoBloco">
                                <div class="proccessar">
                                    <i class="fa fa-spinner fa-spin mx-2" aria-hidden="true"></i>
                                </div>
                                <div class="DivBatePapo">
                                    <div class="logoEmpresaBatePapo">
                                        <img src="/storage/logo/logos.png" alt="" style="width: 30px;">
                                        <span>Sisgesc</span>
                                    </div>
                                    <div class="BatePapo">
                                        Bate Papos
                                    </div>
                                </div>
                                <div class="blocoUsuarios">
                                    @foreach ($users as $user)
                                        <div class="UsuariosBatePapos" IdUser="{{$user->id}}">
                                            <img src="/csss/configuarcoes/img_user/{{$user->imagem}} " alt="">
                                            <div class="NomeCompleto">{{$user->nome_completo}} </div>
                                            <div class="NaoLida {{$user->id}}">{{
                                            DB::table('bate_papos_models')
                                                ->where('IdUserPrincipal',$user->id)
                                                ->where('IdUserDestino',session('id_admin'))
                                                ->where('estado','não lida')->count();}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div>
                            <li class="Use">{{$user->apelido}}</li>
                            <div class="bg-white border rounded Usuario">
                                <div class="Sair">Sair  <i class="fa fa-sign-out"></i></div>
                            </div>
                        </div>
                    </div>
                </ul>
            </nav>
        </div>
    @show
    @yield('header')
    <script src="csss/ponto_de_venda/ponto_de_venda.js"></script>
