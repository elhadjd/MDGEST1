<div class="w-100 DivOrdensVenda">
    <title>Ordens de vendas</title>
    <div class="mt-5">
        <div class="d-flex w-100 OrdenCima">
            <div class="OrdenCimaEsquerda w-50">
                <h4 class="text-secondary TipoMuve ms-4">{{$tipoMuv}}</h4>
            </div>
        </div>
        <div>
            <div class="d-flex titleOrden text-secondary border-bottom w-100">
                <strong class="d-flex w-100">
                    <div class="w-25">Artigos</div>
                    <div>Ref Da Orden</div>
                    <div>Funcionario</div>
                    <div>Data</div>
                    <div class="Direita">Quantidade</div>
                </strong>
            </div>
            <div class="overflow-auto bg-white h-75 ListaOrden">
                @foreach ($muv as $encomenda)
                @if ($tipoMuv == 'Muvementos')
                    <div class="d-none">{{$quantidade = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('id_do_artigo',$IdProd)->sum('quantidade')}} </div>
                    <div class="d-none">{{$muvementos = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('id_do_artigo',$IdProd)->get()}}</div>
                @elseif($tipoMuv == 'Vendido')
                    <div class="d-none">{{$quantidade = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('tipo_de_operacao','Saida Pos')->where('id_do_artigo',$IdProd)->sum('quantidade')}} </div>
                    <div class="d-none">{{$muvementos = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('tipo_de_operacao','Saida Pos')->where('id_do_artigo',$IdProd)->get()}}</div>
                @elseif($tipoMuv == 'Comprados')
                    <div class="d-none">{{$quantidade = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('tipo_de_operacao','!=','Saida Pos')->where('tipo_de_operacao','!=','Saida')->where('id_do_artigo',$IdProd)->sum('quantidade')}} </div>
                    <div class="d-none">{{$muvementos = DB::table('muvementos_de_stock')->where('dia',str_replace(' ','',$encomenda->dia))->where('tipo_de_operacao','!=','Saida Pos')->where('tipo_de_operacao','!=','Saida')->where('id_do_artigo',$IdProd)->get()}}</div>
                @endif
                <div class=" border-bottom MostrarLista" idLinha="{{$encomenda->id}}">
                    <div class="d-flex ListMuvementos p-1" id_orden="{{$encomenda->id}}">
                        <div class="w-50">{{"Data :  ".$encomenda->created_at->format('d-m-Y')}}</div>
                        <div class="TotalOrden pr-1 w-50">{{"Quantidade :  ".Number_format($quantidade,2,",",".")."Un(s)"}}</div>
                        @if ($tipoMuv == 'Vendido')
                        <div class="TotalOrden pr-1 w-50">{{"Total :  ".Number_format($quantidade * DB::table('lista_de_pedidos')->where('id_artigo',$IdProd)->pluck('preco_custo')->first(),2,",",".")."Kz"}}</div>
                        @endif
                    </div>
                </div>
                <div class="Esconder border-bottom {{$encomenda->id}}">
                    @foreach ($muvementos as $item)
                    <div class="d-flex text-secondary ListaDeMuvementos" id_orden="{{$item->id_da_orden}}">
                        <div class="w-25">{{(DB::table('produtos')->where('id',$item->id_do_artigo)->pluck('nome')->first())}}</div>
                        <div>{{"Orden ".$item->id_da_orden}}</div>
                        <div>{{DB::table('tb_usuariolog')->where('id',$item->id_responsavel)->pluck('apelido')->first()}}</div>
                        <div>{{(date('d-m-Y à\s H:i:s',strtotime($item->data)))}}</div>
                        <div class="Direita">{{Number_format($item->quantidade,2,",",".")."Un(s)"}}</div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="ResultListPedidos d-none position-absolute w-100 h-100 bg-white top-0"></div>
                <script>
                    // $(".ResultListPedidos").hide()
                    // // A clicar na linha da orden
                    // $(".ListaDeMuvementos").click(function(){
                    //     var id_orden = $(this).attr('id_orden');
                    //     $.ajax({
                    //         type : "GET",
                    //         url : "/ListPedido",
                    //         data : {
                    //             id_orden : id_orden,
                    //         },
                    //         success : function(data){
                    //             $(".ResultListPedidos").html(data)
                    //             $(".ResultListPedidos").show()
                    //         }
                    //     });
                    // });
                </script>
            </div>
        </div>
    </div>
</div>
<script src="csss/produtos/muvementos.js"></script>

