@if (isset($fornecer))
  @foreach ($fornecer as $nomes)
      <div>
        <div class="dropdown-item estadoss" id="nomes_fornecedor" colun="id_fornecedor" value="{{$nomes->id}}">{{ $nomes->nome}}</div>
      </div>
  @endforeach
@elseif(isset($artigos))
<div class="form-control">
    @foreach ($artigos as $item)
        <div id="{{$item->id}}" class="artigo_encontrado">{{$item->nome}} </div>
    @endforeach
</div>
    <script type="text/javascript" src="csss/compras/novo_pedido_compra.js"></script>
@else
<div class="form-control zindex-modal conteiner h-100 p-0 w-80">
    <div class="form-control p-1  w-100 d-flex">
        <div>
            <div class="btn btn-secondary" id="fechar_janela_de_nova_orden" value="{{$id_principal_orden}}">Fechar</div>
            <div class="btn btn-secondary f-2">Imprimir</div>
        </div>
        @if (str_replace(' ','',$estado)== 'Cotaçao')
        <div>
            <div class="btn btn-primary left-25 bataos" value="Confirmado">Confirmar pedido</div>
        </div>
        @elseif(str_replace(' ','',$estado)== 'Confirmado')
        <div>
            <div class="btn text-info validar"  value="Validado">Validar</div>
            <div class="btn btn-primary bataos" value="Cotaçao">Editar</div>
        </div>
        @elseif(str_replace(' ','',$estado)== 'Validado')
        <div>
            <div class="btn btn-primary add_pagamento" id="{{$id_principal_orden}}">Adicionar pagamento</div>
            <div class="btn">Enviar</div>
            <div class="btn">Nota de credito</div>
        </div>
        @elseif(str_replace(' ','',$estado)== 'Pago')
        <div class="btn">Enviar</div>
        @endif
    </div>
    <div value="{{$id_principal_orden}}"></div>
    <div class="form-control p-1 h-25 d-flex">
        <div class="w-25 h-100 float-reight">
            <dt class="col-sm-3 text-secondary w-100">Orden de Compra</dt>
            <h2 class="text-secondary" class="id_orden" id="{{$id_principal_orden}}"> {{"Orden0".$id_principal_orden}} </h2>
        </div>
        <div class="w-50 " id="compo_fornecer">
            <div class="d-flex">
                <label for="input_fornecedor">Fornecedor</label>
                <!-- Example single danger button -->
                <div class="btn-group w-75 espacho_fornecedor">
                    <div type="button" class="btn btn-light form-control w-100 " id="select_fernecedor" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">{{$nome_de_fornecedor}} </div>
                    <div class="dropdown-menu w-100 border-white t-0">
                        <input type="search" name="pesquisar_fernecedor" placeholder="Nome de fornecedor" id="pesquisar_fernecedor">
                        <div id="result">
                        </div>
                        <div class="btn btn-primary" id="criar_fornece">Criar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-25 p-1 ">
            <dt class="col-sm-3 text-secondary text-center w-100">Armagen</dt>
            <div class="btn-group w-100">
                <button type="button" id="MonstrarArmagens" class="btn btn-light w-100 dropdown-toggle" data-toggle="dropdown">
                    @if ($idArmagen !='')
                        {{DB::table('armagens_models')->where('id',$idArmagen)->pluck('NomeArmagen')->first()}}
                    @else
                    Selectionar armagen
                    @endif
                </button>
                <div id="divArmagens" class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item armagen" IdArmagen="{{'0'}}">Deixar em branco</button>
                    @foreach ($armagens as $armagen)
                        <button class="dropdown-item armagen" IdArmagen="{{$armagen->id}}" idord="{{$id_principal_orden}}">{{$armagen->NomeArmagen}}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="div_pagamento"></div>
    <div class="form-control lista_dos_pedidos overflow-auto">
        <div id="bootom">
            @foreach ($lista_prod_pedido as $produtos)
                <div class="d-flex" id="linhas_de_pedido">
                    <div class="mx-1 d-flex icone" id_orden="{{$produtos->id_Orden}}" value="{{$produtos->id}}"><i class="fa fa-anchor mt-1"></i>{{$produtos->id_Orden}}</div>
                    <div class="w-25 mx-1 show">
                        <div class=" mx-1 nome_artigo" id_orden="{{$produtos->id_Orden}}" id="nome_artigo">{{mb_strimwidth($produtos->artigo,0,20)}}</div>
                    </div>
                    <div class="w-25 d-flex mx-1"><strong>Quantidade</strong><input type="text" class="form-control mx-1 updatee"  id_linha="{{$produtos->id}}" tipo="quantidade" name="quantidade" id="quantidade" value="{{number_format($produtos->quantidade,2,",")}}" placeholder="0,00Un(s) " class=""></div>
                    <div class="w-25 d-flex mx-1">Custo<input type="text" name="custo_unidade" class="form-control mx-2 borders-none updatee"  id_linha="{{$produtos->id}}" tipo="custo" id="custo_unidade" value="{{number_format($produtos->custo,2,",",".")."Kz"}}" placeholder=" {{ number_format(0,2,".",".")."Kz" }} "></div>
                    <div class="w-25 d-flex mx-1">Desconto<input type="text" name="desconto" class="form-control mx-2 borders-none updatee"  id_linha="{{$produtos->id}}" tipo="desconto"  id="desconto" value="{{number_format($produtos->desconto,2,",",".")."%"}}" placeholder="Desconto 0%"></div>
                    <div class="w-25 mx-1 d-flex">Iva<input type="text" name="iva" class="form-control mx-2 borders-none updatee"  id_linha="{{$produtos->id}}" tipo="iva"  id="iva" value="{{number_format($produtos->iva,2,",",".")."%"}}" placeholder="Iva 0%"></div>
                    <div class="w-25 d-flex mx-1">Preço C/IVA
                        <div class="mx-1">{{number_format($produtos->preco_final,2,",",".")."Kz"}}</div>
                    </div>
                    <div class="w-25 mx-1 total">{{number_format($produtos->total,2,".",",")."Kz"}}</div>
                    <div class="apagar" id="{{$produtos->id}}" value="{{$id_principal_orden}}"><i class="fa fa-minus" aria-hidden="true"></i></div>
                </div>
            @endforeach
        </div>
    </div>
    @if (str_replace(' ','',$estado) != 'Cotaçao')
        @else
        <div class="text-primary form-control-sm p-2" id="regular" value="{{$id_principal_orden}}">Aplicar</div>
    @endif
    <div class="form-control mt-1 total_da_orden w-25" >
        <div class="d-flex">
            <div class="text-secondary">
                <div>Total de mercadoria</div>
                <div>Desconto comercial</div>
                <div>Iva</div>
            </div>
            <div class="totais_da_orden">
                <div class="text-secondary">{{number_format($total_sem_desconto,2,",",".")."Kz"}}</div>
                <div class="text-secondary">{{number_format($total_desconto,2,",",".")."Kz"}}</div>
                <div class="text-secondary">{{number_format($total_iva,2,",",".")."Kz"}}</div>
            </div>
        </div>
        @if(str_replace(' ','',$estado)== 'Validado')
        <div class="d-flex mt-2">
            <div class="text-secondary">
                <div>Total da fatura</div>
                <div>Valor a pagar</div>
            </div>
            <div class="totais_da_orden">
                <div class="text-secondary">{{number_format($total_orden,2,",",".")."Kz"}}</div>
                <div class="text-secondary">{{number_format($valor_pago,2,",",".")."Kz"}}</div>
            </div>
        </div>
        <div class="form-control p-0 w-100"></div>
        <div class="d-flex p-2 text-secondary " >
            @if ($valor_a_pagar < 0)
            <div><strong>Troco</strong></div>
            <div class="text-secondary valor_a_pagar totais_da_orden">{{number_format(str_replace('-','',$valor_a_pagar),2,",",".")."Kz"}}</div>
            @else
            <div><strong>Total a pagar</strong></div>
            <div class="text-secondary valor_a_pagar totais_da_orden">{{number_format($valor_a_pagar,2,",",".")."Kz"}}</div>
            @endif
        </div>
        @elseif(str_replace(' ','',$estado)== 'Pago')
        <div class="d-flex mt-2">
            <div class="text-secondary">
                <div>Total da fatura</div>
                <div>Valor a pagar</div>
            </div>
            <div class="totais_da_orden">
                <div class="text-secondary">{{number_format($total_orden,2,",",".")."Kz"}}</div>
                <div class="text-secondary">{{number_format($valor_pago,2,",",".")."Kz"}}</div>
            </div>
        </div>
        <div class="form-control p-0 w-100"></div>
        <div class="d-flex p-2 text-secondary ">
            <div><strong>Total a pagar</strong></div>
            <div class="text-secondary valor_a_pagar totais_da_orden">{{number_format($valor_a_pagar,2,",",".")."Kz"}}</div>
        </div>
        @elseif (str_replace(' ','',$estado)!='Validado')
        <div class="form-control p-0 w-100"></div>
        <div class="d-flex p-2 text-secondary " >
            <div><strong>Total da fatura</strong></div>
            <div class="text-secondary totais_da_orden">{{number_format($total_orden,2,",",".")."Kz"}}</div>
        </div>
        @endif
    </div>
    @if (str_replace(' ','',$estado) != 'Cotaçao')
        @else
        <div id="add_prod" class="p-1" value="{{$id_principal_orden}}">
            Adicionar artigo
        </div>
    @endif
</div>
@endif
<script type="text/javascript" src="csss/compras/novo_pedido_compra.js"></script>



