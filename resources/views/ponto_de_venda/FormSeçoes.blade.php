<div class="shadow-lg">
    <div class="form-control p-0" id="FormSession">
        <div class="form-control p-0 d-flex text-secondary FormSessionCima">
            <div class="form-control">{{'A abrir controlo'}}</div>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <div class="form-control">{{'Em progresso'}}</div>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <div class="form-control">{{'Controlo encerrado'}}</div>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </div>
        <div class="form-control FormSessionMeio d-flex text-secondary w-100">
            <div>
                @if (str_replace(' ','',$session->estado)=="Aabrir")
                <div class="btn BtnColor botoesCaixa" idSession="{{$session->id}}">Abrir controlo</div>
                @elseif(str_replace(' ','',$session->estado)=="Aberto")
                <div class="btn BtnColor Continuar botoesCaixa" id_caixa="{{$session->id_da_caixa}}">Continuar</div>
                <div class="btn btn-secondary mx-1 botoesCaixa" idSession="{{$session->id}}">Fechar</div>
                @else
                @endif
            </div>
            <div class="d-flex mx-5 ">
                <div class="text-center">
                    <div>Data de abertura</div>
                    <div class="linha"></div>
                    <div>{{$session->created_at}} </div>
                </div>
                @if (str_replace(' ','',$session->estado)== 'Aabrir')
                <div id="diInputAbertura"><input type="number" name="abertura" id="aberturaInput" placeholder="Valor de abertura"></div>
                @elseif (str_replace(' ','',$session->estado)== 'Fechado')
                <div class="text-center mx-3">
                    <div>Data de Fecho</div>
                    <div class="linha"></div>
                    <div>{{$session->updated_at}} </div>
                </div>
                <div class="text-center mx-3">
                    <div>Valor Enformado</div>
                    <div class="linha"></div>
                    <div>{{number_format($valorEnformado,2,",",".")."Kz"}} </div>
                </div>
                <div class="text-center mx-3">
                    <div>Diferencia</div>
                    <div class="linha"></div>
                    <div>{{Number_format($diferencia,2,",",".")."Kz"}}</div>
                </div>
                @endif
            </div>
            @if (str_replace(' ','',$session->estado)=="Aberto")
            <div class="w-50">
                <input type="number" name="velorEnformado" id="velorEnformado" class="text-secondary h5" placeholder="Por favor digite valor para enformar , exemplo({{Number_format(1,2,",",".")."Kz"}})">
            </div>
            @endif
        </div>
        <div class="divCaixaResponsavel d-flex mt-3 ms-4 text-secondary">
            <div class="w-25">
                <div><span><strong>Responsavel  </strong></span></div>
                <div class="mt-3"><span><strong>Ponto de venda  </strong></span></div>
                @if (str_replace(' ','',$session->estado)!="Aabrir")
                <div class="mt-3"><span><strong>Abertura  </strong></span></div>
                <div class="mt-3"><span><strong>Trasaçoes  </strong></span></div>
                <div class="mt-3"><span><strong>Entrada  </strong></span></div>
                <div class="mt-3"><span><strong>Saida  </strong></span></div>
                <div class="mt-3"><span><strong>Valor Numerario</strong></span></div>
                @endif
            </div>
            <div class=" linha"></div>
            <div class="ms-2 w-25">
                <div>{{DB::table('tb_usuariolog')->where('id',$session->id_user_responsavel)->pluck('apelido')->first()}}</div>
                <div class="mt-3">{{DB::table('caixas')->where('id',$session->id_da_caixa)->pluck('nome')->first()}}</div>
                @if (str_replace(' ','',$session->estado)!="Aabrir")
                <div class="mt-3">{{Number_format($session->saldo_de_abertura,2,",",".")."Kz"}}</div>
                <div class="mt-3">{{Number_format($transaçoes,2,",",".")."Kz"}}</div>
                <div class="mt-3">{{Number_format(0,2,",",".")."Kz"}}</div>
                <div class="mt-3">{{Number_format(0,2,",",".")."Kz"}}</div>
                <div class="mt-3">{{Number_format($total,2,",",".")."Kz"}}</div>
                {{$pedidos}}
                @endif
            </div>
            @if (str_replace(' ','',$session->estado)!="Aabrir")
            <div class="d-flex p-0 form-control bg-white w-50 h-auto">
                <div id="MultTrans" class="form-control ms-1">
                    <div class="multicaixa w-100 shadow-sm rounded bg-white">
                        <div class="titleMult mt-1 text-center">
                            <div class="mt-2">Multicaixa</div>
                            <div class="mt-4"><strong>{{Number_format($multicaixa,2,",",".")."Kz"}}</strong></div>
                        </div>
                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                    </div>
                    <div class="transferencia mt-1 shadow-sm rounded bg-white">
                        <i class="fa fa-exchange" aria-hidden="true"></i>
                        <div class="titleTransferen text-center">
                            <div class="">Transferencia</div>
                            <div class="mt-2"><strong>{{Number_format($transferencia,2,",",".")."Kz"}}</strong></div>
                        </div>
                    </div>
                </div>
                <div class="w-50">
                    <div class="totalValor d-block w-100 text-center text-secondary">
                        <label for="" class="h2"><strong>Total</strong></label><br>
                        <strong class="text-center" id="totalValor">{{Number_format($totalGeral,2,",",".")."Kz"}} </strong>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="csss/ponto_de_venda/SessaoCaixa.js"></script>

