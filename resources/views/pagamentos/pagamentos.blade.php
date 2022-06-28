<link rel="stylesheet" href="/csss/pagamentos/pagamento.css">
<div class="d-flex form-control" id="divpagamento">
    <div class="w-75 form-control" id="method_de_pagamento">
        <div id="method_pagamento" class="form-control-sm">
            <div class="d-flex p-2 methodos" tipos="Numerario">
                <i class="fa fa-money " aria-hidden="true"></i>
                <div class="tipos">Numerario</div>
            </div>
            <div class="d-flex p-2 methodos" tipos="Transferencia">
                <i class="fa fa-exchange" aria-hidden="true"></i>
                <div class="tipos">Transferencia</div>
            </div>
            <div class="d-flex p-2 methodos" tipos="Multicaixa">
                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                <div class="tipos">Multicaixa</div>
            </div>
        </div>
        <div class="form-control-sm p-2"><strong>Preenche pagamento</strong></div>
        <div id="input_pagamento" class="form-control">
            <div>
                <div><label for="digite_valor">Digite valor</label></div>
                <input type="text" name="digite_valor" id="digite_valor" placeholder="{{number_format(0,2,",",".")."Kz"}} ">
            </div>
        </div>
        <div id="tipo_pag" class="d-none"></div>
    </div>
    <div class="w-25 bg-succes form-control" id="totais">
        <div class="text-secondary">
            <div class="text-center"><strong>Detalho da sua compra</strong></div>
            <div class="d-flex form-control-sm mt-3 total_de_produto">
                <div>Produtos</div>
                <div class="total">{{number_format($orden->total,2,",",".")."Kz"}} </div>
            </div>
            <div class="d-flex form-control-sm mt-3 total_a_pagr">
                <div>A pagar</div>
                <div class="a_pagar">{{number_format($a_pagar,2,",",".")."Kz"}}</div>
            </div>
        </div>
        <div class="position-relative mt-3">
            <div class="bottom-100 w-100">
                <div class="btn btn-primary w-100 pagar" table="pagamentos_de_compras" id_orden="{{$orden->id}}">Pagar</div>
            </div>
        </div>
    </div>
</div>
<script type="" src="/csss/pagamentos/pagamento.js"></script>