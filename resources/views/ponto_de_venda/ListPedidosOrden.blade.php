<link rel="stylesheet" href="/csss/ponto_de_venda/ponto_de_venda.css">
<div class="ArquivoPedidos w-100">
    <div>
        <div class="w-100 FormListaCima mt-4 bg-white">
            <h4 class="ListOrdenClick ms-4 mt-5 text-secondary">Ordens</h4>
        </div>
        <div class="form-control border-0  w-100 overflow-auto FormListaBaixo">
            <div class="d-flex form-control bg-white border-top-0 rounded-0">
                <button type="button" data-value="paid" title="Current state" aria-checked="true" role="radio" class="btn btn-white border text-secondary annular p-2" id_encomenda="{{$encomendas->id}}" aria-current="step">
                    Devolver Artigos
                </button>
            </div>
            <div class="FormListPedidos">
                <div class="form-control rounded-0 bg-white">
                    Confirmado
                </div>
                <div class="mx-4">
                    <div class="mt-4 text-secondary">
                        <div class="d-flex">
                            <div class="font-weight-600 InformacoesEncomenda">
                                <div>Ref da Orden</div>
                                <div>Sessão</div>
                                <div>Caixa</div>
                                <div>Cliente</div>
                            </div>
                            <div class="border ms-5 mt-1"></div>
                            <div class="Infos ms-4">
                                <div>{{"Orden".$encomendas->id}}</div>
                                <div>{{"Sessão".$encomendas->id_session}} </div>
                                <div>{{DB::table('caixas')->where('id',$encomendas->id_caixa)->pluck('nome')->first()}} </div>
                                <div>{{$encomendas->cliente}} </div>
                            </div>
                        </div>
                    </div>
                    <div class="BorderBottom mt-3">
                        <div class="d-flex form-contrl titloListPedidos text-secondary border-0 bg-light rounded-0">
                            <div class="w-25 boder-left">Artigos</div>
                            <div class="boder-left direita">Quantidade</div>
                            <div class="boder-left direita">Preço Unitario</div>
                            <div class="boder-left direita">Disconto</div>
                            <div class="boder-left direita">Emposto</div>
                            <div class="text-right boder-left direita">Total</div>
                        </div>
                        @foreach ($pedidos as $pedido)
                        <div class="d-flex ListPedidos text-secondary">
                            <div class="w-25">{{DB::table('produtos')->where('id',$pedido->id_artigo)->pluck('nome')->first()}}</div>
                            <div class="direita">{{Number_format($pedido->quantidade,2,",",".")."Un(s)"}}</div>
                            <div class="direita">{{Number_format($pedido->preco_venda,2,",",".")."Kz"}}</div>
                            <div class="direita">{{Number_format($pedido->total_desconto,2,",",".")."%"}}</div>
                            <div class="direita">{{Number_format(0,2,",",".")."%"}}</div>
                            <div class="direita">{{Number_format($pedido->total,2,",",".")."Kz"}}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="w-100 form-control-sm text-secondary">
                        <div class="d-flex Totaless w-25 ">
                            <div class="TitleTotaies w-50">
                                <div>Total : </div>
                                <div>Valor Pago :</div>
                                <div>Troco :</div>
                                <div>Margin :</div>
                            </div>
                            <div class="Totaies w-50">
                                <div>{{Number_format($encomendas->total,2,",",".")."Kz"}}</div>
                                <div>{{Number_format($totalPago,2,",",".")."Kz"}}</div>
                                <div>{{Number_format(str_replace('-','',$pagamento->troco),2,",",".")."Kz"}}</div>
                                <div>{{Number_format($margin,2,",",".")."Kz"}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".ListOrdenClick").click(function(){
        var IdOrden = $("#PesquisarOrden").val();
        $.ajax({
            type : "GET",
            url : "/BuscarOrden",
            data : {
                IdOrden : IdOrden,
            },
            success : function(data){
                $(".ListaOrden").html(data)
                $(".ResultListPedidos").hide()
            }
        });
    });
    // A clicar no botao annular a encomenda
    $(".annular").click(function(){
        var id_encomenda = $(this).attr("id_encomenda");
        // A annular esta orden de venda
        $.ajax({
            type : "GET",
            url : "/AnnularOrdenden",
            data : {
                id_encomenda : id_encomenda
            },
            success : function(){
                    $.ajax({
                    type : "GET",
                    url : "/ListPedido",
                    data : {
                        id_orden : id_encomenda,
                    },
                    success : function(data){
                        $(".ResultListPedidos").html(data)
                        $(".ResultListPedidos").show()
                    }
                });
            }
        })
    });
</script>
