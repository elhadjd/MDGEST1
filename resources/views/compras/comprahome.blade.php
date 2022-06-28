@extends('layotus.footer')

@extends('layotus.default')
@extends('layouts.MenuApp')

@section('header')
@section('title','lista de sidebar')
<link rel="stylesheet" href="/csss/produtos/produtos.css">
<div class="botao"><i class="fa fa-th-large" aria-hidden="true"></i></div>
<div id="compras">
    <div id="menssagem" class="w-50"></div>
    {{-- Div de novo fornecedore --}}
    {{-- Dive das novas ordens  --}}
    <div id="add_new_ordens" class="form-control position-absolute"></div>
    {{-- div dos pagamentos --}}
    <div class="pagamentos"></div>

    <div class="lista_dos_produtoss"></div>

    <div class="info_orden">
        <h2 class="mx-20">Orden das compras</h2>
        <div class="d-flex">
            <div class="btn btn-primary " id="criar_uma_compra">Criar</div>
            <div class="div_da_pesquisa">
                <div id="psquisa" class="d-flex">
                    <div id="filtro" class="text-secondary">
                        <div id="filtro_tit" class="form-control-sm">Filtro</div>
                        <div id="lista_de_filtro" class="form-control">
                            <div>
                                <div id="estado" class="form-control-sm">Estado</div>
                                <div id="estados" class="form-control">
                                    <div class="estadoss" colun="estado" value="Cotaçao">Cotaçao</div>
                                    <div class="estadoss" colun="estado" value="Confirmado">Confirmado</div>
                                    <div class="estadoss" colun="estado" value="Pago">Pago</div>
                                </div>
                            </div>
                            <div>
                                <div id="fornece" class="form-control-sm">Fornecedor</div>
                                <div id="fornecedoress" class="form-control w-auto">

                                </div>
                            </div>
                            <div>
                                <div class="form-control-sm" id="por_totais">Total</div>
                                <div id="por_totals" class="form-control w-100">
                                    <div>
                                        <div class="totales" id="por_maior">Maior do que</div>
                                        <div id="por_maiores" class="form-control">
                                            <input type="text" name="por_maiores" class="form-control input_por_valor" placeholder=" {{number_format(0,2,",",".")."Kz"}} ">
                                            <div class="form-control-sm text-primary mt-1 mx-1 p-1 estadoss" colun="total" value="maior">Aplicar</div>
                                        </div>
                                    </div>
                                    <div id="por_valor_recebido" class="d-none"></div>
                                    <div>
                                        <div class="totales" id="por_menor">Menor do que</div>
                                        <div id="por_menores" class="form-control">
                                            <input type="text" name="por_menores" class="form-control input_por_valor" placeholder=" {{number_format(0,2,",",".")."Kz"}} ">
                                            <div class="form-control-sm text-primary mt-1 mx-1 p-1 estadoss" colun="total" value="menor">Aplicar</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="totales" id="por_egual">Egual</div>
                                        <div id="por_eguais" class="form-control">
                                            <input type="text" name="por_eguais" class="form-control input_por_valor" placeholder=" {{number_format(0,2,",",".")."Kz"}} ">
                                            <div class="form-control-sm text-primary mt-1 mx-1 p-1 estadoss" colun="total" value="egual">Aplicar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="por_datass" class="form-control-sm">Data</div>
                                <div id="por_datas" class="form-control">
                                    <div>
                                        <select name="dia" id="dia" class="form-select">
                                            <option name="dia">Selecione dia</option>
                                            @for ($i = 1; $i <=31; $i++)
                                            <option name="dia">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <select name="mes" id="mes" class="form-select">
                                            <option name="mes" id="mess">Selecione mes</option>
                                            <option name="mes" id="mess">Janero</option>
                                            <option name="mes" id="mess">Fevereiro</option>
                                            <option name="mes" id="mess">Março</option>
                                            <option name="mes" id="mess">Abril</option>
                                            <option name="mes" id="mess">Maio</option>
                                            <option name="mes" id="mess">Junho</option>
                                            <option name="mes" id="mess">Julho</option>
                                            <option name="mes" id="mess">Agosto</option>
                                            <option name="mes" id="mess">Setembro</option>
                                            <option name="mes" id="mess">Otubro</option>
                                            <option name="mes" id="mess">Novembro</option>
                                            <option name="mes" id="mess">Dezembro</option>
                                        </select>
                                    </div>
                                    <div id="aplicar_por_datas" class="form-contro text-primary p-1 estadoss" colun="dia" mes="mes">Aplicar</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <i class="fa fa-search icones"></i>
                    <input type="search" name="search_orden" id="search_orden" placeholder="Por favor digite apenas numaros Exemplo(10) " class="form-control">
                </div>
            </div>
        </div>
        <div class="form-control bg_compra">
            <div class="d-flex text-secondary" id="orden_title" >
                <div>Referencia da compra</div>
                <div>Fornecedor</div>
                <div>Data da encomenda</div>
                <div>Responsavel</div>
                <div>Estado</div>
                <div>Total</div>
            </div>
            <div id="lista_orden_das_pesquisa">

            </div>
        </div>
    </div>
    <div>
        <div class="form-control position-absolute overflow-auto" id="lista_de_artigossss">
            <div class="form-control-sm text-secondary titlo">
                <div class="text-center size-400">Lista de artigo</div>
            </div>
            <div id="idiss" class="d-none"></div>
            <div class="meio_da_tabela h-50 form-control">
                <div><input type="search" name="pesquisar_prod" id="pesquisar_prod" class="form-control " placeholder="Digite o nome do artigo aqui"></div>
                <div class="list mt-2">
                </div>
            </div>
            <div class="position-absolute form-control baixo_da_lista_artigo d-flex p-1">
                <div class="text-secondary ms-2 p-1 fecaho_lista_artigo">Fechar</div>
                <div class="text-info ms-2 p-1 novo_artigo">Novo artigo</div>
            </div>
        </div>
    </div>
</div>
@endsection
    @section('footer')
    @endsection
