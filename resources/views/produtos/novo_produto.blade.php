
<script src="{{ asset('csss/produtos/produtos.js') }}" defer></script>
<link rel="stylesheet" href="/csss/produtos/produtos.css">
<div class="position-absolute top-0 w-100 h-100 bg-white ResultMuvementosProd" value="{{$produto->id}}"></div>
<div class="app novo_produto">
    <div class="titlo_novo_produto text-secondary"><span>Novo produto</span></div>
    <div class="form-control w-100 altura_da_form">
        <form method="POST" action="/testandoForm" enctype="multipart/form-data" id="FormNewProd">
            @csrf
            <div class="bg-light form-control div_btn_guard_descart">
                <div class="d-flex form-control-sm btn_guardar_descartar">
                    <button name="guardar" class="btn btn-primary guardar_produto">Guardar</button>
                    <div class="btn btn-secondary mx-2 nao_guadar_artigo">Descartar</div>
                    <div class="btn btn-light EntraSai" value="{{$produto->id}}">Entrada do stock</div>
                    <div class="btn btn-light ms-2 EntraSai" value="{{$produto->id}}">Saida do stock</div>
                    <div class="btn btn-light  ms-2 Detalhar" value="{{$produto->id}}">Detalhar</div>
                </div>
            </div>
            <div class="resultMuv position-absolute w-100 h-100 zindex-1080"></div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="form-control form_novo_prod mt-1">
                <div class="d-flex">
                    <div class="d-flex icones">
                        <label for="imagem" id="edit_img">
                            <input type="file" name="imagem" id="imagem" class="position-absolute ">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </label>
                        <div id="icone_delete_img"><i class="fa fa-ban" aria-hidden="true"></i></div>
                        <input type="hidden" name="idProd" value="{{$produto->id}} ">
                    </div>
                    <label for="" class="imagem_novo_produto">
                        <img src="/storage/produtos/{{$produto->imagem}}" alt="" class="rounded float-right">
                    </label>
                    <div class="mt-1 form-control-sm input_nome_tipo text-secondary">
                        <div>
                            <label for="nome_do_artigo">Nome do produto</label>
                            <input type="text" name="nome_do_artigo" class="form-control nome_artigo_data"
                            id="nome_do_artigo" coluna="nome" id_prod="{{$produto->id}}" placeholder="Digite nome de produto" value="{{$produto->nome}}">
                        </div>
                        <div class="mt-2">
                            <label for="tipo_artigo">Tipo de produto</label>
                            <select name="tipo_artigo" class="form-select w-25 nome_artigo_data" id="tipo_artigo">
                                <option value="">{{$produto->tipoartigo}}</option>
                                <option value="">Artigo armagenavel</option>
                                <option value="">Serviço</option>
                            </select>
                        </div>
                    </div>
                    <div class="muvementos_deste_artigo form-control w-25 p-1">
                        <div class="d-flex">
                            <div class="w-49 form-control d-flex view_muvementos" value="{{$produto->id}}" tipoMuv="Muvementos" id="view_muvementos">
                                <i class="fa fa-exchange"></i>
                                <div class="mx-3 muv">
                                    <div>{{Number_format($movementos,2,".",",")."Un(s)"}} </div>
                                    <strong class="TipoMuv">Muvementos</strong>
                                </div>
                            </div>
                            <div class="mx-1 form-control d-flex  view_muvementos" value="{{$produto->id}}" tipoMuv="Comprados" id="view_muvementos">
                                <i class="fa fa-cart-plus"></i>
                                <div class="mx-3">
                                    <div>{{Number_format($Entrada,2,".",",")."Un(s)"}}</div>
                                    <strong class="TipoMuv">Comprados</strong>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-1">
                            <div class="w-49 form-control d-flex view_muvementos" value="{{$produto->id}}" tipoMuv="Vendido" id="view_muvementos">
                                <i class="fa fa-shopping-basket"></i>
                                <div class="mx-3 muv">
                                    <div>{{Number_format($Saida,2,".",",")."Un(s)"}}</div>
                                    <strong class="TipoMuv">Vendido</strong>
                                </div>
                            </div>
                            <div class="mx-1 form-control d-flex " id="view_muvementos">
                                <i class="fa fa-bar-chart"></i>
                                <div class="mx-3">
                                    <div>{{Number_format($produto->qtd + DB::table('stocks')->where('IdArtigo',$produto->id)->sum('quantidade'),2,".",",")."Un(s)"}}</div>
                                    <strong class="TipoMuv">Stock real</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-control-sm mt-3">
                    <div class="d-flex botoes_do_meio text-secondary">
                        <div class="info_prod" tipo="informacoes" id_prod="{{$produto->id}}">Informação</div>
                        <div class="info_prod" tipo="fornecedor" id_prod="{{$produto->id}}">Fornecedore</div>
                        <div class="info_prod" tipo="list_price" id_prod="{{$produto->id}}">Lista de preço</div>
                        <div class="info_prod" tipo="outro" id_prod="{{$produto->id}}">Outro</div>
                    </div>
                    <div id="information_prod">

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('csss/produtos/novo_prod.js') }}" defer></script>
