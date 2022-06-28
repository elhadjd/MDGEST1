
@foreach ($produtos as $item)
<div class=" d-flex mt-1 linhas_artigos" linha="{{$id_linha}}" orden="{{$id_orden}}" id="{{$item->id}}">
    <div class="w-50 ms-3"> {{$item->nome}} </div>
    @if ($item->qtd<=0)
    <div class="w-25 text-danger"><i class="fa fa-inbox text-danger mx-2" aria-hidden="true"></i>{{number_format($item->qtd,2,",")."Un(s)"}} </div>
    @else
    <div class="w-25"><i class="fa fa-inbox text-info mx-2" aria-hidden="true"></i>{{number_format($item->qtd,2,",")."Un(s)"}} </div>
    @endif
    <div class="w-25">{{number_format($item->preçocust,2,",",".")."Kz"}} </div>
    <div class="w-25">{{number_format($item->preçovenda,2,",",".")."Kz"}}</div>
</div>
@endforeach
<script>
    $(".linhas_artigos").click(function(){
        var id_da_linha = $(this).attr("linha")
        var id_da_orden = $(this).attr("orden")
        var id_artigo = $(this).attr("id")
        $.ajax({
            type : "GET",
            url : "/adicionar_artigo?id_da_linha="+id_da_linha+"&id_da_orden="+id_da_orden+"&id_artigo="+id_artigo,
            success: function(){
                $("#add_new_ordens").load("/add_new_orden?id_principal_orden="+id_da_orden);
                $("#lista_de_artigossss").hide()
            }
        });
    });
</script>