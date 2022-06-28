
<link rel="stylesheet" href="/csss/Pos/recibo.css">
<div class="fatura">
    <a href="Pos" id="NovaEncomenda">Nova Encomenda</a>
    <div class="">
        <div id="recibo">
            <div id="EmpresaEnfo">
                <h2 class="">Leonardo RV comercio e servisos (SU) LDA</h2>
                <div><strong>NIF : </strong>5000623423</div>
                <div><strong>TEL : </strong>842642918</div>
            </div>
            <div>
                <div class="Titls">
                    <div class=""><strong>Quantidade</strong></div>
                    <div class=""><strong>Preço</strong></div>
                    <div class="totalTitl"><strong>Total</strong></div>
                </div>
                @foreach ($lista as $listas)
                <div class="listaItens">
                    <div>{{DB::table('produtos')->where('id',$listas->id_artigo)->pluck('nome')->first()}} </div>
                    <div class="PrecoQuant">
                        <div class="QuantidadeFatura">{{Number_format($listas->quantidade,2,".")."Un"}}</div>
                        <div class="PrecoFatura">{{Number_format($listas->preco_venda,2,",",".")."Kz"}}</div>
                        <div class="TotalFatura">{{Number_format($listas->total,2,",",".")."Kz"}}</div>
                    </div>
                </div>
                @endforeach
                <div class=" InfoPag">
                    <div class="TiposPag">
                        <div><strong>Total</strong></div>
                        @if ($pagamento->numerario !=0)
                        <div><strong>Numerario</strong></div>
                        @endif
                        @if ($pagamento->multicaixa !=0)
                        <div><strong>Multicaixa</strong></div>
                        @endif
                        @if($pagamento->trasferencia !=0)
                        <div><strong>Transferencia</strong></div>
                        @endif
                        <div><strong>Troco</strong></div>
                    </div>
                    <div class="totais">
                        <div>{{Number_format($total->total,2,",",".")."Kz"}}</div>
                        @if ($pagamento->numerario >0)
                        <div>{{Number_format($pagamento->numerario,2,",",".")."Kz"}}</div>
                        @endif
                        @if ($pagamento->multicaixa >0)
                        <div>{{Number_format($pagamento->multicaixa,2,",",".")."Kz"}}</div>
                        @endif
                        @if($pagamento->trasferencia >0)
                        <div>{{Number_format($pagamento->trasferencia,2,",",".")."Kz"}}</div>
                        @endif
                        <div>{{Number_format(str_replace('-','',$pagamento->troco),2,",",".")."Kz"}}</div>
                    </div>
                </div>
                <div class="">
                    <span class="">{!! DNS1D::getBarcodeHTML($total->id, 'PHARMA') !!}</span>
                    <span>{{"IdPos".$total->id}} </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="App"></div>
<script type="text/javascript" src="csss/jquery.min.js"></script>
<script>
    window.print();
</script>
<script src="csss/Pos/recibo.js"></script>
