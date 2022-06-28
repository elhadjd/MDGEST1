@if (isset($encomendas))
    @foreach ($encomendas as $encomenda)
    <div class="d-flex border-bottom ListaOrdens p-1" id_orden="{{$encomenda->id}}">
        <div><strong>{{"Orden".$encomenda->id}}</strong></div>
        <div>{{DB::table('caixas')->where('id',$encomenda->id_caixa)->pluck('nome')->first()}}</div>
        <div>{{"Session".$encomenda->id_session}}</div>
        <div>{{$encomenda->cliente}}</div>
        <div>{{(date('d-m-Y à\s H:i:s',strtotime($encomenda->created_at)))}}</div>
        <div>{{DB::table('tb_usuariolog')->where('id',$encomenda->id_responsavel)->pluck('apelido')->first()}}</div>
        <div class="TotalOrden pr-1">{{Number_format($encomenda->total,2,",",".")."Kz"}}</div>
        <div class="px-5">{{$encomenda->estado}} </div>
    </div>
    @endforeach
    <div class="ResultListPedidos position-absolute w-100 h-100 bg-white top-0"></div>
    <script>
        $(".ResultListPedidos").hide()
        // A clicar na linha da orden
        $(".ListaOrdens").click(function(){
            var id_orden = $(this).attr('id_orden');
            $.ajax({
                type : "GET",
                url : "/ListPedido",
                data : {
                    id_orden : id_orden,
                },
                success : function(data){
                    $(".ResultListPedidos").html(data)
                    $(".ResultListPedidos").show()
                }
            });
        });
    </script>
@elseif(isset($produtos))
    @foreach ($produtos as $listas)
    <label for="" class="mx-1 mt-2 bloco_artigo" id="bloco_artigo" id_prod="{{$listas->id}}"">
        <div class="d-flex">
            <div id="div_da_imagem"><img src="/csss/produtos/img/{{$listas->imagem}}" alt="" class="rounded float-right"></div>
            <div class="d-flex div_preco_qtd text-secondary">
                <div class="preco_qtd">
                    <div><strong>Nome :</strong> {{mb_strimwidth($listas->nome,0,15)}}</div>
                    <div><strong>Preço :</strong> {{number_format($listas->preçovenda,2,",",".")."Kz"}} </div>
                    <div><strong>Stock :</strong> {{number_format($listas->qtd,2,",")."Un(s)"}}</div>
                </div>
                <div class="strela"><i class="fa fa-star-o text-warning"></i></div>
            </div>
        </div>
    </label>
    <script>
        $(".bloco_artigo").click(function(){
            var id_prod = $(this).attr('id_prod');
            $.ajax({
                type : "GET",
                url : "/novo_produto",
                data : {
                    id_prod: id_prod,
                },
                success : function(e){
                    $(".lista_dos_produtos").hide()
                    $(".novo_produto").show()
                    $(".novo_prod").show();
                    $(".novo_prod").html(e)
                }
            });
        });
    </script>
    @endforeach

@elseif (isset($produtosAvaliation))
@foreach ($produtosAvaliation as $produtos)
<div class="d-none">{{$stock = DB::table('stocks')->where('IdArtigo',$produtos->id)->sum('quantidade')}} </div>
@if ($stock + $produtos->qtd <=0)
<div class="d-flex p-1 border-bottom text-white bg-warning ListaOrdens" id_prod="{{$produtos->id}}">
    <div class="w-25">{{$produtos->nome}}</div>
    <div class="TotalOrden">{{Number_format($stock + $produtos->qtd,2,",",".")}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust  * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($licro = $produtos->preçovenda - $produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($stock + $produtos->qtd * $licro,2,",",".")."Kz"}}</div>
</div>
@elseif($produtos->preçocust >= $produtos->preçovenda)
<div class="d-flex p-1 border-bottom bg-danger text-white ListaOrdens" id_prod="{{$produtos->id}}">
    <div class="w-25">{{$produtos->nome}}</div>
    <div class="TotalOrden">{{Number_format($stock + $stock + $produtos->qtd,2,",",".")}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust  * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($licro = $produtos->preçovenda - $produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($stock + $produtos->qtd * $licro,2,",",".")."Kz"}}</div>
</div>
@else
<div class="d-flex p-1 border-bottom ListaOrdens" id_prod="{{$produtos->id}}">
    <div class="w-25">{{$produtos->nome}}</div>
    <div class="TotalOrden">{{Number_format($stock + $produtos->qtd,2,",",".")}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçocust  * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden">{{Number_format($produtos->preçovenda * $stock + $produtos->qtd,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($licro = $produtos->preçovenda - $produtos->preçocust,2,",",".")."Kz"}}</div>
    <div class="TotalOrden ">{{Number_format($stock + $produtos->qtd * $licro,2,",",".")."Kz"}}</div>
</div>
@endif
@endforeach
<script>
    $(".ListaOrdens").click(function(){
        var id_prod = $(this).attr('id_prod');
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            data : {
                id_prod: id_prod,
            },
            success : function(e){
                $(".novo_prod").show();
                $(".novo_prod").html(e)
                $(".lista_dos_produtos").hide()
            }
        });
    });
</script>
@elseif(isset($ListaGastos))
@foreach ($ListaGastos as $gastos)
    <div class="d-flex border-bottom ListaGastos p-1">
        <div><strong>{{"Gasto".$gastos->id}}</strong></div>
        <div>{{mb_strimwidth($gastos->assunto,0,35)}}</div>
        <div>{{DB::table('tb_usuariolog')->where('id',$gastos->idUser)->pluck('apelido')->first()}}</div>
        <div>{{(date('d-m-Y à\s H:i:s',strtotime($gastos->created_at)))}}</div>
        <div class="TotalOrden pr-1">{{Number_format($gastos->valor,2,",",".")."Kz"}}</div>
    </div>
@endforeach
<div class="position-fixed h1 p-3 text-secondary TotalGastos bg-white mt-3 form-control">
    {{Number_format($total,2,",",".")."Kz"}}
</div>
@elseif ($muvementos)
@foreach ($muvementos as $muvemento)
<div class="w-100 d-flex text-secondary ListaMuvementos" idOrden="{{$muvemento->id_da_orden}}" tipo="{{$muvemento->tipo_de_operacao}}">
    <div class="w-25">{{DB::table('produtos')->where('id',$muvemento->id_do_artigo)->pluck('nome')->first()}} </div>
    <div>{{"Orden".$muvemento->id_da_orden}}</div>
    <div>{{DB::table('tb_usuariolog')->where('id',$muvemento->id_responsavel)->pluck('apelido')->first()}}</div>
    <div>{{Number_format($muvemento->quantidade,2,",",".")."Un(s)"}}</div>
    <div>{{$muvemento->tipo_de_operacao}}</div>
    <div>{{DB::table('armagens_models')->where('id',$muvemento->idArmagen)->pluck('NomeArmagen')->first()}} </div>
    <div>{{$muvemento->data}}</div>
</div>
@endforeach
<script>
    $(".ListaMuvementos").click(function(){
    var idOrden = $(this).attr('idOrden');
    var TipoOperacao = $(this).attr('tipo');
    var id_orden = $(this).attr('id_orden');
    if (TipoOperacao =='Saida Pos') {
        $.ajax({
            type : "GET",
            url : "/ListPedido",
            data : {
                id_orden : idOrden,
            },
            beforeSend : function(){
                $(".processar").show();
            },
            success : function(data){
                $(".processar").hide();
                $(".ResultListPedidos").html(data)
                $(".ResultListPedidos").show()
            }
        });
    } else {
        if (TipoOperacao == 'Entrada Por compra') {
            $.ajax({
                type : "GET",
                url : "/add_new_orden",
                data : {
                    id_principal_orden : idOrden,
                },
                beforeSend : function(){
                    $(".processar").show();
                },
                success : function(data){
                    $(".processar").hide();
                    $("#add_new_ordens").html(data)
                    $("#add_new_ordens").show()
                }
            })
        }
        if (TipoOperacao == 'Saida Retalho') {
            $.ajax({
                type : "GET",
                url : "/ListPedido",
                data : {
                    id_orden : idOrden,
                },
                beforeSend : function(){
                    $(".processar").show();
                },
                success : function(data){
                    $(".processar").hide();
                    $(".ResultListPedidos").html(data)
                    $(".ResultListPedidos").show()
                }
            });
        }
    }
});
</script>
@endif
