

<link rel="stylesheet" href="/csss/produtos/produtos.css">
<div class="novo_prod"></div>
<div class="mt-3 w-100 h-100 lista_dos_produtos">
    <span class="mx-3 text-secondary"><strong>Lista de artigos</strong></span>
    <div class="d-flex">
        <div class="btn text-info btncriar_artigo">Criar</div>
        <div class="d-flex div_da_pesquisa_prod">
            <div class="w-100">
                <input type="search" name="pesqusar_prod" id="pesqusar_prod"
                 placeholder="{{'Digite nome do artigo'}}" table="produtos" colun="nome" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-control w-100 lista_dos_artigose overflow-auto">
        @foreach ($produtos as $listas)
            <label for="" class="mx-1 mt-2 bloco_artigo" id="bloco_artigo" id_prod=" {{$listas->id}} ">
                <div class="d-flex">
                    <div id="div_da_imagem"><img src="/storage/produtos/{{$listas->imagem}}" alt="" class="rounded float-right"></div>
                    <div class="d-flex div_preco_qtd text-secondary">
                        <div class="preco_qtd">
                            <div><strong>Nome :</strong> {{mb_strimwidth($listas->nome,0,15)}}</div>
                            <div><strong>Preço :</strong> {{number_format($listas->preçovenda,2,",",".")."Kz"}} </div>
                            <div><strong>Stock :</strong> {{number_format($listas->qtd + DB::table('stocks')->where('IdArtigo',$listas->id)->sum('quantidade'),2,",")."Un(s)"}}</div>
                        </div>
                        <div class="strela"><i class="fa fa-star-o text-warning"></i></div>
                    </div>
                </div>
            </label>
        @endforeach
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('/csss/produtos/produtos.js') }}" defer></script>
