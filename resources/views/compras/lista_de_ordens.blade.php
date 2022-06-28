<div class="h-75 overflow-auto">
    @foreach ($ordens_compra as $item)
    <div class="d-flex linha_orden" id="{{$item->id}}">
        <div>{{ $item->referencia }}</div>
        <div>{{ \App\Models\fornecedores::where('id',$item->id_fornecedor)->pluck('nome')->first();}}</div>
        <div>{{ $item->data }}</div>
        <div>{{ $item->id_responsavel}}</div>
        @if (str_replace(' ','',$item->estado)=='Cotaçao')
            <div>{{$item->estado}}<i class="fa fa-spinner text-primary mx-2 fa-spin icone z-index-0" aria-hidden="true"></i></div>
        @elseif(str_replace(' ','',$item->estado)=='Confirmado')
            <div>{{str_replace(' ','',$item->estado)}}<i class="fa fa-spinner mx-2 icone text-warning fa-spin fa-0x" aria-hidden="true"></i></div>
        @elseif(str_replace(' ','',$item->estado)=='Validado')
            <div>{{str_replace(' ','',$item->estado)}}<i class="fa fa-circle-o-notch text-info fa-spin fa-0x mx-2" aria-hidden="true"></i></div>
        @elseif(str_replace(' ','',$item->estado)=='Pago')
            <div>{{$item->estado}}<i class="fa fa-check mx-2 icone text-success" aria-hidden="true"></i></div>
        @endif
        <div>{{ number_format($item->total,2,",",".")."Kz" }}</div>
    </div>
    @endforeach
</div>
<script>
    $(".linha_orden").click(function(){
    $("#add_new_ordens").show();
    $(".icones").hide("fast")
    $("#filtro").hide("fast")
    var id_da_linha_clicada = $(this).attr("id");
    $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_da_linha_clicada);
});
</script>
