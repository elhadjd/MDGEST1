<div class="w-100 DivOrdensVendas">
    <title>Ordens de vendas</title>
    <div class="mt-5">
        <div class="d-flex w-100 OrdenCima">
            <div class="OrdenCimaEsquerda w-50">
                <h4 class="text-secondary ms-4">Ordens</h4>
            </div>
            <div class="OrdenCimaDireita w-50">
                <div class="text-secondary">
                    <input type="search" class="w-100" placeholder="Pesquisar por id da orden , Exemplo(110)" name="PesquisarOrden" id="PesquisarOrden">
                    <i class="fa fa-search position-absolute"></i>
                </div>
                <div class="d-flex w-50">
                    <span class="bg-light d-flex p-1 px-2 rounded" role="button">
                        <i class=" fa fa-bars bg-light mx-2" id="Agroupar"></i>
                        <label for="Agroupar" class="mt-1" role="button">Agrupar Por</label>
                        <span class="ListAgrupar form-control bg-white text-secondary for-control shadow p-0 position-absolute mt-4">
                            <div class="w-100">
                                <div class="cursor p-1 px-2">
                                    <div id="por_estado_da_faturas" class="cursor">Estado da fatura</div>
                                    <div id="por_estado_da_fatura" class="border p-0 bg-white encostar  rounded position-absolute">
                                        <div class="dropdown-item agrupar" id="venda_paga" table="encomendas_pos" value="estado">Cotaçao</div>
                                        <div class="dropdown-item agrupar" id="Pago" table="encomendas_pos" value="estado">Pago</div>
                                        <div class="dropdown-item agrupar" id="venda_vencida" table="encomendas_pos" value="estado">Annulado</div>
                                    </div>
                                </div>

                                <div class="cursor p-1 px-2">
                                  <div id="por_ultilizadores" class="cursor">Caixa</div>
                                    <div class="border p-0 encostar bg-white rounded position-absolute" id="por_ultilizadore" >
                                        @foreach ($caixas as $caixa)
                                        <div class="agrupar">{{$caixa->nome}} </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="cursor p-1 px-2">
                                    <div id="por_clientes" class="cursor">Cliente</div>
                                    <div class="border encostar p-0 bg-white rounded position-absolute">

                                    </div>
                                  </div>
                                <div class="cursor p-1 px-2">
                                  <div id="por_datase" class="cursor">Data da encomenda</div>
                                  <div id="por_data" class="border bg-white encostar rounded position-absolute">
                                        <div class="">
                                            <label>Data de inicio</label>
                                            <input type="date" name="inicio" class="form-control" id="inicios">
                                        </div>
                                        <div class="">
                                            <label>Data final</label>
                                            <input type="date" name="fin" class="form-control" id="finall">
                                        </div>
                                        <div class="btn btn-primary" id="validar_por_data">Aplicar</div>
                                  </div>
                                </div>
                              </div>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <div class="d-flex titleOrdens text-secondary w-100">
                <strong class="d-flex w-100">
                    <div>Ref Da Orden</div>
                    <div>Ponto De Venda</div>
                    <div>Sessão</div>
                    <div>Cliente</div>
                    <div>Data</div>
                    <div>Funcionario</div>
                    <div class="TotalOrden">Total</div>
                    <div  class="px-5">Estado</div></strong>
            </div>
            <div class="overflow-auto h-75 ListaOrden">

            </div>
        </div>
    </div>
</div>
<script src="csss/ponto_de_venda/ordenVenda.js"></script>
