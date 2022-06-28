
<div class="w-100 DivOrdensVendas">
    <title>Ordens de vendas</title>
    <div class="mt-5">
        <div class="d-flex w-100 OrdenCima">
            <div class="OrdenCimaEsquerda w-50">
                <h4 class="text-secondary ms-4">Avaliaçao de stock</h4>
            </div>
            <div class="OrdenCimaDireita w-50">
                <div class="text-secondary">
                    <input type="search" class="w-100" placeholder="Pesquisar por id da orden , Exemplo(110)" name="PesquisarOrden" id="PesquisarOrden">
                    <i class="fa fa-search position-absolute"></i>
                </div>
            </div>
        </div>
        <div>
            <div class="d-flex titleOrdens text-secondary w-100">
                <strong class="d-flex w-100">
                    <div class="w-25">Nome do artigo</div>
                    <div class="TotalOrden">Quantidade</div>
                    <div class="TotalOrden">Preço de custo</div>
                    <div class="TotalOrden">Preço de venda</div>
                    <div class="TotalOrden">Total de custo</div>
                    <div class="TotalOrden">Total de venda</div>
                    <div class="TotalOrden">Lucro unitario</div>
                    <div class="TotalOrden">Total de lucro</div>
                </strong>
            </div>
            <div class="position-absolute bottom-0 mb-4 w-100 bg-white">
                <div class="w-100 TotalAvaliaçoes shadow-lg p-1 mb-3 form-control d-flex">
                    <div class="p-2">
                        <span>Total de custo</span>
                        <div class="ms-2">{{Number_format($Costos,2,",",".")."Kz"}}</div>
                    </div>
                    <div>
                        <span>Total de Venda</span>
                        <div class="ms-2">{{Number_format($vanda,2,",",".")."Kz"}}</div>
                    </div>
                    <div>
                        <span>Total de Lucro</span>
                        <div class="ms-2">{{Number_format($lucro,2,",",".")."Kz"}}</div>
                    </div>
                </div>
            </div>
            <div class="overflow-auto h-75 ListaOrden">

            </div>
        </div>
    </div>
    <div class="novo_prod position-fixed w-100 h-100 top-0"></div>
</div>
<script src="csss/ponto_de_venda/avaliation.js"></script>
