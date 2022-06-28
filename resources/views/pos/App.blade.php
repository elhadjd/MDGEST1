@extends('layotus.footer')
@if ($lista != '')
    @if (($total->impresao < 1) OR (DB::table('tb_usuariolog')->where('id',session('id_admin'))->pluck('nivel')->first()=='Administrador') )
    <link rel="stylesheet" href="/csss/Pos/recibo.css">
    <div class="fatura">
        <a href="Pos" id="NovaEncomenda">Nova Encomenda</a>
        <div class="">
            <div id="recibo">
                <div id="EmpresaEnfo">
                    <h2 class="">Leonardo RV comercio e servisos (SU) LDA</h2>
                    @if ($caixa->impresaoCliente == 'true')
                        <div class="telefone">
                            <div>TEL : </div>
                            <div class="numero">+244 942-642-918</div>
                        </div>
                        <div class="nif">
                            <div>NIF : </div>
                            <div class="numero">50006599738</div>
                        </div>
                    @endif
                </div>
                @if ($caixa->impresao == 'true')
                    <div class="Cliente">
                        <strong class="title">Cliente</strong>
                        <div class="InfoCliente">
                            <div>
                                <strong>Nome : </strong>
                                <span>{{$total->cliente}} </span>
                            </div>
                            <div>
                                <strong>Telefone : </strong>
                                <span>{{"+244"}} </span>
                            </div>
                        </div>
                    </div>
                @endif
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
                            <div><strong>Operador</strong></div>
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
                            <div>{{DB::table('caixas')->where('id',$total->id_caixa)->pluck('nome')->first()}} </div>
                        </div>
                    </div>
                    <div>{{"Id : ".$total->id}}</div>
                    <div class="Obrigado">OBRIGADO VOLTE SEMPRE !!!</div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none">{{DB::table('encomendas_pos')->where('id',$total->id)->update(['impresao'=>$total->impresao + 1])}}</div>
    <script>
        window.print();
    </script>
    @endif
    <div class="App"></div>
    <script type="text/javascript" src="csss/jquery.min.js"></script>
    <script src="csss/Pos/recibo.js"></script>
@else
<div class="App"></div>
<script type="text/javascript" src="csss/jquery.min.js"></script>
<script src="csss/Pos/recibo.js"></script>
@endif
@section('footer')
