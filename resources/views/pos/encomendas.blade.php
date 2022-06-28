<div>
    @foreach ($artigos as $lista_de_pedidos)
    <div class="listaPedido" idLinha="{{$lista_de_pedidos->id}}">
        <div style="width: 50%;">{{mb_strimwidth(App\Models\produtos::all()->where('id',$lista_de_pedidos->id_artigo)->pluck('nome')->first(),0,25)}}</div>
        <div class="mx-3 w-auto">{{number_format($lista_de_pedidos->quantidade,2,".")}}</div>
        <div>{{number_format($lista_de_pedidos->preco_venda,2,",",".")."Kz"}}</div>
        <div class="totalEncomeda">{{number_format($lista_de_pedidos->total,2,",",".")."Kz"}}</div>
    </div>
    @endforeach
    <div class="totalEncomendase">
        <div class="totalEncomenda"><strong>Total : </strong>{{Number_format($TotalEncomenda,2,",",".")."Kz"}}</div>
        <div class="posAtivo">{{$pos_ativo}}</div>
    </div>
</div>
<script src="csss/Pos/ListaPedidos.js"></script>
