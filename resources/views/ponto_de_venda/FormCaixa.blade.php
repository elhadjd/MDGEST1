<div class="FormBlocoGeral">
    <title>Cash</title>
    <div class="d-flex w-100 p-1 btnForm">
        <div class="">
            <button class="btn btnGuardar">Guardar</button>
            <button class="btn btn-secondary">Descartar</button>
        </div>
        <div class="text-secondary text-center w-75"><h3><strong>Cash</strong></h3></div>
    </div>
    <div class="form-control  shadow-lg BlocoPointSale">
        <div class="text-secondary p-1">
            <label for="NomeCash" class="mx-2"><strong>Nome</strong></label>
            <input type="text" value="{{$IdCaixa->nome}}" name="NomeCash" id="NomeCash" placeholder="cash name" autofocus required
            tabela="caixas" idCaixa="{{$IdCaixa->id}}" coluna="nome"">
        </div>
        <div class="d-flex">
            <div class="w-50 h-auto p-3">
                <label for="user_relation"><strong>Usuario relationado</strong></label>
                <div class="form-control">
                    <div class="form-select select_user">
                        @if ($IdCaixa->id_user_relation == 0)
                        Clicar para selectionar usuario
                        @else
                        {{DB::table('tb_usuariolog')->where('id',$IdCaixa->id_user_relation)->pluck('apelido')->first()}}
                        @endif
                    </div>
                    <div class="dropdown-menu w-25 lista_user_para_shop">
                        @foreach ($list_user as $usuarios)
                        <div class="dropdown-item FormCaixaClick" tabela="caixas" idCaixa="{{$IdCaixa->id}}" coluna="id_user_relation" idUser="{{$usuarios->id}}">{{$usuarios->apelido}}</div>
                        @endforeach
                    </div>
                </div>
                <label for="Armagen"><strong>Armagen relationado</strong></label>
                <div class="form-control">
                    <div class="form-select selectArmagen">
                        @if ($IdCaixa->Armagen == 0)
                        Clicar para selectionar o armagen relationado
                        @else
                        {{DB::table('armagens_models')->where('id',$IdCaixa->Armagen)->pluck('NomeArmagen')->first()}}
                        @endif
                    </div>
                    <div class="dropdown-menu w-25 ListArmagen">
                        @foreach ($Armagens as $armagen)
                        <div class="dropdown-item FormCaixaClick" tabela="caixas" idCaixa="{{$IdCaixa->id}}" coluna="Armagen" idUser="{{$armagen->id}}">{{$armagen->NomeArmagen}}</div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-3 text-info">
                    <label for="imprsaoAutomatico">Impressão automatico de recibo</label>
                    <input type="checkbox" class="form-check-input FormCaixaClick" @if (str_replace(' ','',$IdCaixa->impresao) == 'true')
                    @checked(true)
                    @endif name="imprsaoAutomatico"  id="imprsaoAutomatico" tabela="caixas" coluna="impresao" idUser="{{$usuarios->id}}" idCaixa="{{$IdCaixa->id}}">
                </div>
                <div class="mt-3 text-info">
                    <label for="impresaoCliente">Imprimir informações de cliente</label>
                    <input type="checkbox" class="form-check-input FormCaixaClick" @if (str_replace(' ','',$IdCaixa->impresaoCliente) == 'true')
                    @checked(true)
                    @endif name="impresaoCliente"  id="impresaoCliente" tabela="caixas" coluna="impresaoCliente" idUser="{{$usuarios->id}}" idCaixa="{{$IdCaixa->id}}">
                </div>
            </div>
            <div class="w-50 h-auto p-3">
                Da direita
            </div>

        </div>
    </div>
</div>
<script src="csss/ponto_de_venda/blocoCaixa.js"></script>
