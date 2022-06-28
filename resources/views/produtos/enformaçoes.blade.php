<link rel="stylesheet" href="/csss/produtos/produtos.css">
@if (isset($informacoes))
    {{-- A construir a informaçao do artigo --}}
    <div class="text-secondary w-100 text-center"><span ><strong>Preços</strong></span></div>
    <div class="d-flex form-control" id="informacoa_prod">
        <div class="informacoa_prod text-secondary w-25">
            <div>Preço de custo</div>
            <div>Preço medio</div>
            <div>Preço de venda</div>
        </div>
        <div class="linha"></div>
        <div id="inputs_informacao" id_prod="{{$informacoes->id}}">
            <div><input type="text" coluna="preçocust" class="input_info text-secondary" name="preco_custo" id="preco_custo"
                placeholder="Preço de custo exemplo  ({{number_format(1,2,",",".")."Kz"}})" value="{{number_format($informacoes->preçocust,2,",",".")."Kz"}}"></div>
            <div><input type="text" coluna="preco_medio" class="input_info text-secondary" name="preco_medio" id="preco_medio"
                placeholder="Preço medio exemplo  ({{number_format(3,2,",",".")."Kz"}})" value="{{number_format($informacoes->preco_medio,2,",",".")."Kz"}}"></div>
            <div><input type="text" coluna="preçovenda" class="input_info text-secondary" name="preco_venda" id="preco_venda"
                placeholder="Preço de venda exemplo  ({{number_format(5,2,",",".")."Kz"}})" value="{{number_format($informacoes->preçovenda,2,",",".")."Kz"}}"></div>
        </div>

    </div>
    {{-- Fin da construiçao do produto --}}
@elseif (isset($fornecedor))
{{-- A construir fornecedor do produto --}}
<div class="text-secondary" id="fornecedore_de_produto">
    <div class="w-100">
        <div><label for="select_fornecedor">Fornecedore</label></div>
        <div class="btn-group w-50 adicionar_fornecedor_para_artigo">
            <div class="w-100" id="select_fornecedor" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if ($fornecedor->fornecedore !='')
                  <div>{{\App\Models\fornecedores::where('id',$fornecedor->fornecedore)->pluck('nome')->first();}}</div>
                @else
              clica a qui para selectionar um fornecedore
              @endif
            </div>
            <div class="dropdown-menu form-control w-50 lista_de_fornecedores_para_produto overflow-auto">
                <div><input type="text" name="search_fornecedor_para_produto" id="search_fornecedor_para_produto" placeholder="Digite a qui nome de fornecedore"
                    tipo="fornecedor" id_prod="{{$fornecedor->id}}" class=""></div>
                <div id="resultado_fonecedores">
                @foreach ($nome_for as $fornecedores)
                <div id="div_nome_fornecedore" id_prod="{{$fornecedor->id}}" id_forn="{{$fornecedores->id}}"
                     class="inputs_info_prod" >{{$fornecedores->nome}}</div>
                @endforeach
                </div>
            </div>
          </div>
    </div>
</div>
{{-- Fin da construiçao de fornecedor --}}
@elseif(isset($list_price))
{{-- A construir lista de preço de artigo --}}
<div id="lista_de_preço_produto">
    <div class="text-secondary w-100 text-center">
        <span><strong>Lista de preço</strong></span>
    </div>
    <div class="form-control w-100 h-75 text-secondary">
        <div class="d-flex w-100" id="linha_lista_de_preco">
            <div class="w-auto mx-3">{{mb_strimwidth($list_price->nome,0,24)}}</div>
            <div id="preco_sem_disconto_list_price" class="w-auto mx-5">
                <label for="preco_sem_disconto_list_price"><strong>Preço</strong></label>
                {{number_format($list_price->preçovenda,2,",",".")."Kz"}}
            </div>
            <div class="w-auto mx-3" id="tipo_de_desconto">
                <div class="w-auto" id="select_fornecedor" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Desconto por embalagem
                </div>
                {{-- <div class="dropdown-menu form-control w-auto mt-2 lista_de_fornecedores_para_produto overflow-auto">
                    <div>Caixa</div>
                    <div>Unidade</div>
                </div> --}}
            </div>
            <div>
                <label for="quantidade_list_price">Quantadade</label>
                <input type="text" name="quantidade_list_price" class="lista_preco" table="lista_de_preco"
                id_prod="{{$list_price->id}}" coluna="quantidade" id="quantidade_list_price"
                value="{{Number_format(DB::table('lista_de_preco')->where('id_produto',$list_price->id)->pluck('quantidade')->first(),2,",",".")."Unidade(s)"}}">
            </div>
            <div>
                <label for="preco_list_price">Preço de desconto</label>
                <input type="text" name="preco_list_price" class="lista_preco" table="lista_de_preco"
                id_prod="{{$list_price->id}}" coluna="preco_de_desconto" id="preco_list_price"
                value="{{Number_format(DB::table('lista_de_preco')->where('id_produto',$list_price->id)->pluck('preco_de_desconto')->first(),2,",",".")."Kz"}}">
            </div>
        </div>
    </div>
    <div class="btn text-info">Adicionar</div>
</div>
{{-- Fin da construiçao de lista de preço --}}
@elseif(isset($outro))
{{-- A construir outras informaçoes do artigo --}}
<div class="d-flex" id="outras_informaçoes">
    outras_informaçoes
</div>
{{-- Fin da construiçao do produto --}}
@endif

<script src="{{ asset('/csss/produtos/novo_prod.js') }}" defer></script>
