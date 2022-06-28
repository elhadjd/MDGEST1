<div class="FormPagamento shadow user-select-none">
    <div class="borders text-center CabechaPagamento text-secondary"><span><strong>Pagemento</strong></span></div>
    <div class="div3">
        <div class="FormPagamentoEsquerda">
            <div class="methodos">
                <div id="ValorNums" class="">Numerario</div>
                <div class="metho">
                    @foreach ($methodo as $methodos)
                    <div class="methodo" nomeMthod="{{str_replace(' ','',$methodos->nome)}}">
                        <strong>{{$methodos->nome." : "}}</strong>
                        <strong class="{{$methodos->nome}} ValorEntregue"></strong>
                    </div>
                    @endforeach
                    <div class="Faturas d-flex">
                        <strong>Fatura</strong>
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <span class="success">Pronto pagamento</span>
                    </div>
                </div>
                <div class="TipoFatura">
                    @foreach ($tipoFaturas as $tipoFatura)
                    <div  class="TiposFaturas">
                        <div class="TipoFaturase">{{$tipoFatura->nome}} </div>
                    </div>
                    @endforeach
                </div>
                <div class="AddMethod"><span>Adicionar</span></div>
                <div id="idIncomenda">{{$encomenda->id}}</div>
            </div>
        </div>
        <div class="FormPagamentoDireita">
            <div id="totalEncomendaPagamento">
                <h1 class="TotalEncomendas">{{Number_format($total,2,",",".")."Kz"}}</h1>
                <div class="CalculoTotal">
                    <div class="div4">
                        <h3 class="div5">
                            <strong>Restante : </strong>
                            <span id="restoAPagar"></span>
                        </h3>
                        <h5 class="div5">
                            <span>Toatal da compra</span>
                            <span id="TotalCompra"></span>
                        </h5>
                    </div>
                    <div class="div6">
                        <div class="troco">
                            <span >
                                <strong>Troco : </strong>
                                <strong id="TrocoCliente"></strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nume">
                <div id="FrPgNum">
                    <div class="FormTecladoPagamento">
                        <div class="FormTecladoPagamentos">
                                @for ($i = 1; $i < 10; $i++)
                                <div class="tecladoNumeros user-select-none"><strong>{{$i}}</strong></div>
                                @endfor
                                <div class="tecladoNumeros user-select-none"><strong>0</strong></div>
                                <div class="tecladoNumeros user-select-none"><strong>.</strong></div>
                                <div class="tecladoNumeros user-select-none" id="TiraNumeros"><strong><i class="fa fa-ban"></i></strong></div>
                        </div>
                    </div>
                    <div class="div7">
                        <div class=" DinheiroPegado user-select-none">
                            <div class="DinheiroPegue">
                                <div class="NumerosPegado static">100</div>
                                <div class="NumerosPegado">200</div>
                                <div class="NumerosPegado">500</div>
                                <div class="NumerosPegado">1000</div>
                                <div class="NumerosPegado">2000</div>
                                <div class="NumerosPegado">8000</div>
                            </div>
                            <div class="DinheiroPegue">
                                <div class="NumerosPegado">3000</div>
                                <div class="NumerosPegado">4000</div>
                                <div class="NumerosPegado">5000</div>
                                <div class="NumerosPegado">6000</div>
                                <div class="NumerosPegado">7000</div>
                                <div class="NumerosPegado">10000</div>
                            </div>
                        </div>
                        <div class="DivValirCanselar">
                            <div id="CanselarPagamento" class="user-select-none"><i class="fa fa-angle-double-left"></i> Canselar</div>
                            <div id="ValidarPagamento" @click="$emit('someEvent')" class="user-select-none">Validar <i class="fa fa-angle-double-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="numeral/min/numeral.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="csss/Pos/pagamento.js"></script>
