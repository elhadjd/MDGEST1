         <link rel="stylesheet" href="/csss/Pos/pos.css">
         <link href="{{ asset('css/app.css') }}" rel="stylesheet">
         <link rel="icon" type="image/png" href="/storage/logo/log.png"/>
 <title>Grande Pos</title>
    </head>
    <body>
    <header id="headerPos">
        <nav class="">
            <li>
                <strong>
                    SISGESC
                </strong>
            </li>
            <div class="" id="pos">
                @for ($i = 1; $i < 6; $i++)
                <div class="pos">Pos{{$i}}</div>
                @endfor
            </div>
            <div id="UsuarioConectado">
                <div class="alerta shadow-lg"></div>
                <div class="menssagensChat">
                    <div class="VenUserMenssagen">
                        <span class="novasMenssagens"></span>
                        <i class="fa fa-comments-o icone" aria-hidden="true"></i>
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
                    {{$usuario->apelido}}
                </div>
            </div>
        </nav>
    </header>
<div class="MenuPos user-select-none">
    <div class="Posesquerda">
        <div>
            <div class="esquerdaCima">
            </div>
            <div class="esquerdaBaixo">
                <div class="FormPagamentoCima">
                    <div class="div2">
                        <span>
                            <input type="search" name="NomeCliente" placeholder="Pesqise pelo nome do cliente" id="NomeCliente">
                        </span>
                        <div id="ResultadoClientes" class="shadow"></div>
                        <div class="AdicionarCliente">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div id="novoCliente" class="shadow">
                            <div>
                                <span class="IdCliente"></span>
                                <h3>Novo Cliente</h3>
                                <div class="border-top p-3 border-bottom">
                                    <input type="text" name="NomeDoCliente" id="NomeDoCliente">
                                </div>
                                <div id="FormClienteBaixo">
                                    <div class="fecharBloco">Fechar</div>
                                    <div id="GuardarCliente">Confirmar</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="QtdPrcImpr">
                        <div class="">Imprimir</div>
                        <div class="açoes" tipo="preco_venda">Preço</div>
                        <div class="açoes" tipo="desconto">Desconto</div>
                        <div class="açoes" tipo="quantidade">Quantidade</div>
                    </div>
                </div>
                <div class="FormPagamentoBaixo">
                    <div class="PagamentoEsquerda">
                        <i class="fa fa-credit-card-alt"></i>
                        <div>Pagamento</div>
                    </div>
                    {{-- Dives para alterar quantidade e preços e descontos --}}
                    <div id="NumerosClicados" class="position-absolute d-none"></div>
                    <div class="idss position-absolute d-none"></div>
                    <div class="TipoAcçao">quantidade</div>
                    {{-- ^========================================================== --}}
                    <div class="PagamentoDireita text-center">
                        @for ($i = 1; $i < 10; $i++)
                        <div class="nomeros" id="numero"> {{$i}}</div>
                        @endfor
                        <div class="nomeros" id="numero">{{0}}</div>
                        <div class="nomeros" id="numero">.</div>
                        <div id="numeros"><i class="fa fa-ban"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="Posdireita">
        <div class="direitaCima">
            <div class="div1">
                <i class="fa fa-search i"></i>
                <input type="search" name="PesquisarProduto" placeholder="Pesquisar produto" class="form-control" id="PesquisarProduto" autofocus>
            </div>
            <div class="SairPos close">Close  <i class="fa fa-sign-out"></i></div>
        </div>
        <div class="direitaBaixo ">
        </div>
    </div>
</div>
<div class="w-100 Recibo h-100 position-absolute top-0">
</div>
<div class="pagamento position-absolute top-0 w-100 h-100 zindex-1060">
</div>
<script src="csss/Pos/ListaArtigos.js"></script>
<script src="csss/BatePapo.js"></script>
<script>

 // A clicar nus numeros
 $(".nomeros").click(function(){
    var numero = $(this).text();
    var numeros = $("#NumerosClicados").text();
    $("#NumerosClicados").text(numeros + numero);
    var num = $("#NumerosClicados").text();
    var IdProd = $(".idss").text();
    var TipoAçao = $(".TipoAcçao").text();
    $.ajax({
        type : "GET",
        url : "/AlterarLinhaPedido",
        data : {
            numeros: num,
            TipoAçao : TipoAçao,
            IdProd : IdProd,
        },
        success : function(e){
            $(".menssagem").show("fast");
            $(".menssagem").html(e);
            // A buscar o bloco encomenda
            $.ajax({
                type : "GET",
                url : "/buscarEncomenda",
                data : {
                    id_caixa : 1,
                    id_session : 1,
                    pos_ativo : $(".posAtivo").text(),
                },
                success : function(data){
                    $(".esquerdaCima").html(data)
                }
            });
        }
    });
 });
 // A clicar na div apagar uma linha de pedido
 $("#numeros").click(function(){
    var IdProd = $(".idss").text();
    $.ajax({
        type : "GET",
        url : "/ApagarLinhaPedido",
        data : {
            IdProd : IdProd,
        },
        success : function(e){
            $(".menssagem").show("fast");
            $(".menssagem").html(e);
            // A buscar o bloco encomenda
            $.ajax({
                type : "GET",
                url : "/buscarEncomenda",
                data : {
                    id_caixa : 1,
                    id_session : 1,
                    pos_ativo : $(".posAtivo").text(),
                },
                success : function(data){
                    $(".esquerdaCima").html(data)
                }
            });
        }
    });
 })
$(".SairPos").click(function(){
    $.ajax({
        type : "GET",
        url : "/SairPos",
        success  : function(){
            window.location.href="/Pos"
        }
    });
});

// A esconder o bloco novos clientes
$("#novoCliente").hide()
// A clicar no botao criar cliente
$(".AdicionarCliente").click(function(){
    $.ajax({
        type : "GET",
        url : "/NovoCliente",
        data : {dados : 'CriarId'},
        success : function(e){
            $("#novoCliente").show()
            $(".IdCliente").html(e)
        }
    })
})
// A Mandar nome do cliente no banco de dados
$("#GuardarCliente").click(function(){
    var nome = $("#NomeDoCliente").val();
    var id = $(".IdCliente").text()
    $.ajax({
        type : "GET",
        url : "/NovoCliente",
        data : {NomeCliente : nome,id : id},
        success : function(e){
            $("#novoCliente").hide()
            $("#NomeCliente").val(e)
        }
    })
})


// A pesquisar cliente pelo nome do cliente
$("#NomeCliente").keyup(function(){
    var nomeCliente = $(this).val();
    $.ajax({
        type : "GET",
        url : "/NovoCliente",
        data : {nomeCliente : nomeCliente},
        success : function(e){
            $("#ResultadoClientes").show();
            $("#ResultadoClientes").html(e)
        }
    })
})

$("#ResultadoClientes").hide();
// A  fechar bloco cliente
$(".fecharBloco").click(function(){
    $("#novoCliente").hide()
})
</script>
