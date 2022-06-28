<div class="borderse">
    <title>Lista de pagamentos</title>
    <div class="text-secondary text-center"><h4><strong>Lista de pagamentos</strong></h4></div>
    <div>
        <div id="div_input_psq_pagamentos">
            <input type="text" name="pesquisar_pagamento" id="pesquisar_pagamento" class="" placeholder="Pesquisa pelo numero da orden Exemplo(10)">
        </div>
    </div>
    <div class="form-control w-100 resultado_psq_pagamentos">
        <div class="d-flex form-control titls_list_ordens">
            <div>Orden da fatura</div>
            <div>Responsavel</div>
            <div>Fornecedore</div>
            <div>Data de encomenda</div>
            <div>Estado</div>
            <div>Total da orden</div>
        </div>

        <div class="form-control lista_dos_pagamentos overflow-auto">
            @foreach ($lista_de_orden as $lista_de_ordens)
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
        </div>
        <div class="form-control text-right">
            <div class="d-flex totais_das_ordens">
                <div><strong>Total das ordens : </strong>{{number_format($totais,2,",",".")."Kz"}}</div>
                <div class="mx-5"><strong>Valor pago : </strong>{{number_format($pago,2,",",".")."Kz"}}</div>
                <div><strong>Valor a pagar : </strong>{{number_format($a_pagar,2,",",".")."Kz"}}</div>
            </div>
        </div>
    </div>
</div>
<script type="" src="/csss/pagamentos/pagamento.js"></script>
