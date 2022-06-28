<div class="w-75 fecha shadow-lg h-75 bg-success" style="margin-top: 6%">
    <div class="">
        @if (isset($resutado))
            <div class="d-flex text-secondary w-100 titlsMovementosProd">
                <div class="w-50">Nome</div>
                <div class="direita">Preço de custo</div>
                <div class="direita">Preço de venda</div>
                <div class="direita">Quantidade vendido</div>
            </div>
            <div class="overflow-auto bg-white text-secondary h-100">
                @foreach ($resutado as $item)
                    <div class="w-100 d-flex p-1 ListaMovementosProd" id_prod="{{$item->idProd}} ">
                        <div class="w-50">{{mb_strimwidth(DB::table('produtos')->where('id',$item->idProd)->pluck('nome')->first(),0,35)}}</div>
                        <div class="direita">{{Number_format(DB::table('produtos')->where('id',$item->idProd)->pluck('preçocust')->first(),2,",",".")."Kz"}}</div>
                        <div class="direita">{{Number_format(DB::table('produtos')->where('id',$item->idProd)->pluck('preçovenda')->first(),2,",",".")."Kz"}}</div>
                        <div class="direita">{{Number_format($item->quantidade,2,",",".")."Un(s)"}}</div>
                    </div>
                @endforeach
            </div>
        @elseif(isset($margin))
            <div class="d-flex text-secondary w-100 titlsMovementosProd">
                <div class="w-50">Nome</div>
                <div class="direita">Preço de custo</div>
                <div class="direita">Preço de venda</div>
                <div class="direita">Margin do produto</div>
            </div>
            <div class="overflow-auto bg-white text-secondary h-100">
                @foreach ($margin as $item)
                    <div class="w-100 d-flex p-1 ListaMovementosProd" id_prod="{{$item->id_prod}} ">
                        <div class="w-50">{{mb_strimwidth(DB::table('produtos')->where('id',$item->id_prod)->pluck('nome')->first(),0,35)}}</div>
                        <div class="direita">{{Number_format(DB::table('produtos')->where('id',$item->id_prod)->pluck('preçocust')->first(),2,",",".")."Kz"}}</div>
                        <div class="direita">{{Number_format(DB::table('produtos')->where('id',$item->id_prod)->pluck('preçovenda')->first(),2,",",".")."Kz"}}</div>
                        <div class="direita">{{Number_format($item->margin,2,",",".")."Kz"}}</div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="btn btn-secondary FecharBlocoMuve position-absolute">Fechar</div>
    </div>
</div>
<div class="BlocoProd w-100 position-absolute top-0 bg-white"></div>
<script>
    $(".BlocoProd").hide();
    $(".guardar_produto").click(function(){
        $(".BlocoProd").hide();
    })
    $(".ListaMovementosProd").click(function(){
        var id_prod = $(this).attr('id_prod');
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            data : {
                id_prod: id_prod,
            },
            success : function(e){
                $(".BlocoProd").show();
                $(".BlocoProd").html(e)
            }
        });
    });
    $(".FecharBlocoMuve").click(function(){
        $(".ResultadoMovementosProd").css('height','1%')
    $(".fecha").hide()
    $(".ResultadoMovementosProd").hide();
})
</script>
