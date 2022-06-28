<div class="w-50 h-auto bg-white shadow rounded">
    <div id="IdArmagen"></div>
    <div class="text-secondary text-center border-bottom"><h3 class="p-1">{{$tipoOper}}</h3></div>
    <div class="p-2">
        <div class="w-100 p-1 d-flex text-secondary h5">
            <label for="" class="w-50"><strong>Artigo principal</strong></label>
            <label for="" class="w-50 text-center"><strong>Armagen</strong></label>
        </div>
        <div class="d-flex bg-light">
            <div class="w-50 p-2">{{mb_strimwidth($artigo->nome,0,25)}}</div>
            <div class="btn-group w-50">
                <button type="button" id="MonstrarArmagens" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                    Selectionar armagen
                </button>
                <div id="divArmagens" class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item armagen" IdArmagen="{{''}}">Deixar em branco</button>
                    @foreach ($armagens as $armagen)
                        <button class="dropdown-item armagen" IdArmagen="{{$armagen->id}}">{{$armagen->NomeArmagen}}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex quantidades mt-4 p-2 text-secondary w-100 border-bottom">
            <div class="quantidadeExist w-50 d-flexe">
                <div><strong>{{Number_format($stock,2,",",".")."Un(s)"}}</strong></div>
                <div class="w-100 text-right"><i class="fa fa-bar-chart w-100 mt-2 ms-2"></i></div>
            </div>
            <div class="w-75">
                <strong>Quantidade</strong>
                <input type="number" name="quantidadeDetalhar"
                 class="QuantidadeDetalho w-100" coluna="Quantidade" idLinha="{{0}}"
                 placeholder="{{Number_format(0,2,",",".")."Un(s)"}}"
                 id="quantidadeDetalhar">
            </div>
        </div>
        <div class="d-flex w-100 mt-2">
            <div class="btn btn-secondary ms-1 ">Fechar</div>
            <div class="btn btn-primary ms-1 ConfirmarStock" TipoOper="{{$tipoOper}}" idArtigo="{{$artigo->id}}">Confirmar</div>
        </div>
    </div>
</div>

<script src="{{ asset('csss/produtos/EntradaSaida.js') }}" defer></script>
