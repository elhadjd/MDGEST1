<div class="w-50 h-auto bg-white shadow rounded">
    <div class="text-secondary text-center border-bottom"><h3 class="p-1">Detalhar artigos</h3></div>
    <div class="p-2">
        <div class="w-100 p-1 d-flex text-secondary h5">
            <label for="" class="w-50"><strong>Artigo principal</strong></label>
            <label for="" class="w-25"><strong>Pesquisar</strong></label>
            <label for="" class="w-25"><strong>Artigo detalhado</strong></label>
        </div>
        <div class="d-flex bg-light p-1">
            <div class="w-50 ">{{mb_strimwidth($artigo->nome,0,25)}}</div>
            <div class="w-25"><input type="search" name="NomeArtigo" placeholder="Nome de artigo" idPrin="{{$artigo->id}}" id="NomeArtigo" class="form-control p-0 ps-2"></div>
            <div class="ms-2 w-25">
                <div id="ResultadoPesqusa" class="rounded bg-white text-secondary overflow-auto shadow border position-absolute">
                    {{mb_strimwidth(DB::table('produtos')->where('id',$infos->idArtigodetalhado)->pluck('nome')->first(),0,20)}}
                </div>
            </div>
        </div>
        <div class="d-flex quantidades mt-4 p-2 text-secondary border-bottom">
            <div class="quantidadeExist d-flexe">
                <div><strong>{{Number_format($artigo->qtd,2,",",".")."Un(s)"}}</strong></div>
                <div class="w-100 text-right"><i class="fa fa-bar-chart w-100 mt-2 ms-2"></i></div>
            </div>
            <div class="">
                <strong>Quantidade</strong>
                <input type="number" name="quantidadeDetalhar"
                 class="QuantidadeDetalho" coluna="Quantidade" idLinha="{{$infos->id}}"
                 placeholder="{{Number_format($infos->Quantidade,2,",",".")."Un(s)"}}"
                 value="{{Number_format($infos->Quantidade,2,",",".")}}" id="quantidadeDetalhar">
            </div>
            <div class="">
                <strong>Progersso</strong>
                <input type="number" name="QuantidadeOnline"
                 class="QuantidadeDetalho" coluna="QuantidadeTemporaria" idLinha="{{$infos->id}}"
                 placeholder="{{Number_format($infos->QuantidadeTemporaria,2,",",".")."Un(s)"}}"
                  id="QuantidadeOnline" value="{{Number_format($infos->QuantidadeTemporaria,2,",",".")}}">
            </div>
        </div>
        <div class="d-flex w-100 mt-2">
            <div class="btn btn-danger ms-1 EliminarDetalho" idLinha="{{$infos->id}}">Eliminar</div>
            <div class="btn btn-primary ms-1 fecharJanela">Confirmar</div>
        </div>
    </div>
</div>

<script src="{{ asset('csss/produtos/QuantidadesPreços.js') }}" defer></script>
