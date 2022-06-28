
<link rel="stylesheet" href="/csss/Stock/Stock.css">
<div class="w-100 h-100">
    <div class="ListaArtigos w-100 h-100 position-adsolute top-0">

    </div>
    <div class="w-75 FormListeStock border p-1 rounded bg-white h-100">
        <div class="d-flex border-bottom TitleStockArmagen">
            <div class="w-25">Artigo</div>
            <div>Armagen</div>
            <div>Quantidade</div>
            <div>Preço de custo</div>
            <div>Preço de venda</div>
            <div>Lucro</div>
        </div>
        <div class="overflow-auto w-100 h-100">
            <div class="d-none">{{$lucro = 0, $totalCusto = 0,$totalVenda = 0}}</div>
            @foreach ($Stock as $item)
                <div class="ListStockArmagen text-secondary d-flex" id_prod="{{$item->IdArtigo}}">
                    <div class="w-25">{{mb_strimwidth(DB::table('produtos')->where('id',$item->IdArtigo)->pluck('nome')->first(),0,25)}} </div>
                    <div class="">{{mb_strimwidth(DB::table('armagens_models')->where('id',$item->IdArmagen)->pluck('NomeArmagen')->first(),0,15)}} </div>
                    <div>{{Number_format($item->quantidade,2,",",".")."Un(s)"}}</div>
                    <div>{{Number_format($custo = DB::table('produtos')->where('id',$item->IdArtigo)->pluck('preçocust')->first(),2,",",".")."Kz"}} </div>
                    <div>{{Number_format($venda = DB::table('produtos')->where('id',$item->IdArtigo)->pluck('preçovenda')->first(),2,",",".")."Kz"}} </div>
                    <div>{{
                        Number_format($total = $item->quantidade * $venda - $item->quantidade * $custo,2,",",".")."Kz";
                    }}</div>
                    <div class="d-none">{{
                    $lucro += $total,
                    $Custo = $item->quantidade * $custo,
                    $venda = $item->quantidade * $venda,
                    $totalCusto +=$Custo,
                    $totalVenda +=$venda,
                    }} </div>
                </div>
            @endforeach
        </div>
        <div class="position-absolute TotaisStockArmagen bottom-0 w-75 d-flex p-2">
            <div class="w-50">{{"Total de Custo : ".Number_format($totalCusto,2,",",".")."Kz"}}</div>
            <div class="w-50">{{"Total de Venda : ".Number_format($totalVenda,2,",",".")."Kz"}}</div>
            <div class="w-50">{{"Lucro : ".Number_format($lucro,2,",",".")."Kz"}}</div>
        </div>
    </div>
</div>
<script>
    $(".ListaArtigos").hide()
    $(".ListStockArmagen").click(function(){
        var id_prod = $(this).attr('id_prod');
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            data : {
                id_prod: id_prod,
            },
            beforeSend : function(){
                $(".processar").show();
            },
            success : function(e){
                $(".FormListeStock").hide()
                $(".processar").hide();
                $(".ListaArtigos").show()
                $(".ListaArtigos").html(e)
            }
        });
    })
</script>
