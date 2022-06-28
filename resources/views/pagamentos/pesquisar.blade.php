@foreach ($pagamentos as $lista_de_ordens)
    <div class="d-flex lista_de_orden" id_orden="{{$lista_de_ordens->referencia}}" id="lista_de_orden">
        <div>{{$lista_de_ordens->referencia}}</div>
        <div>{{ DB::table('tb_usuariolog')->where('id',$lista_de_ordens->id_responsavel)->pluck('apelido')->first();}}</div>
        <div>{{ DB::table('fornecedores')->where('id',$lista_de_ordens->id_fornecedor)->pluck('nome')->first();}}</div>
        <div>{{(date('d/m/Y à\s H:i:s',strtotime($lista_de_ordens->data)))}}</div>
        <div>{{$lista_de_ordens->estado}}</div>
        <div id="total_da_orden">{{number_format($lista_de_ordens->total,2,",",".")."Kz"}}</div>
    </div>
    <div class="pagamento_show {{$lista_de_ordens->referencia}}">
    </div>
@endforeach
<script>
    $(".pagamento_show").hide();
    $(".lista_de_orden").click(function(){
    var orden = $(this).attr("id_orden");
    $("."+orden).toggle("fast")
    var ordens = orden.replace('Orden0','');
    $.ajax({
        type : "GET",
        url : "/buscar_pagamentos",
        data : {
            pagamento_id : ordens,
        },
        success : function(e){
            $("."+orden).html(e);
        }
    })
});
</script>