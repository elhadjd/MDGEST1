<div class="w-100 DivOrdensVendas">
    <title>Gastos da empresa</title>
    <div class="mt-5">
        <div class="w-100 OrdenCima">
            <h4 class="text-secondary">GASTOS</h4>
            <div class="d-flex w-100 position-absolute">
                <div class="GastosCimaEsquerda w-50">
                    <div class="btn AdicionarGastos btn-primary">Adicionar</div>
                </div>
                <div class="GastosCimaDireita w-50">
                    <div><input type="text" name="PesquuisarGasto" placeholder="Pesquisar por data , Exemplo(01-01-2001)" id="PesquuisarGasto" class="w-100 p-2 form-control"></div>
                </div>
            </div>
        </div>
        <div>
            <div class="d-flex titleGastos text-secondary w-100">
                <strong class="d-flex w-100">
                    <div>Id de muvemento</div>
                    <div>Assunto</div>
                    <div>Funcionario</div>
                    <div>Data</div>
                    <div class="TotalOrden">Total</div>
                </strong>
            </div>
            <div class="overflow-auto h-75 ListaOrden">

            </div>
        </div>
    </div>
    <div class="position-absolute BlocoGasto w-100 top-0 d-flex justify-content-center">
        <div class="w-50 h-50 bg-white BlocoGasto shadow rounded mt-5 pb-4">
            <div class="text-secondary justify-content-center d-flex ">
                <p class="IdGasto d-none"></p>
                <h3>NOVO GASTO</h3>
            </div>
            <div class="w-100 h-75 border-top p-4">
                <div class="w-100">
                    <textarea name="Assunto" id="Assunto" placeholder="Assunto obligatorio" class="w-100" ></textarea>
                </div>
                <div class="d-flex mt-3">
                    <div class="w-50 text-secondary pt-1">
                        <label for="">Responsavel</label>
                        <h4 class="responsavel"></h4>
                    </div>
                    <div class="w-50">
                        <label for="ValorGasto">Valor</label>
                        <input type="number" class="form-control ValorGasto" placeholder="Digite valor a gastar" name="ValorGasto" id="ValorGasto">
                    </div>
                </div>
                <div class="d-flex BlocoNovoGastoBaixo">
                    <div class="btn btn-secondary facharJanela mt-2">Fechar</div>
                    <div class="btn btn-primary ConfirmarGasto ms-2 mt-2">
                        Conformar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="csss/ponto_de_venda/gastos.js"></script>
