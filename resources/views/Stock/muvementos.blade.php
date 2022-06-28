<link rel="stylesheet" href="/csss/Stock/Stock.css">


<div class="w-100 h-100 bg-white">
    <div id="add_new_ordens" class="form-control h-100 position-absolute"></div>
    <div class="MuvementosCima d-flex">
        <div class="mt-2 text-secondary w-50">
            <div><h3>Muvementos de stock</h3></div>
            <div class="btn btn-primary CrearTransferencia">Criar Transferencia</div>
        </div>
            {{-- odal transferencia --}}
<!-- Button trigger modal -->
<div class="w-75 position-absolute FormTranferencia rounded border h-50 bg-white ms-10 shadow xindex-1060 ">
</div>
        <div class="w-50">
            <div class="w-100 ms-3">
                <label for="PesquisarMuvemento">Pesquisar</label>
                <input type="search" name="PesquisarMuvemento" class="form-control p-0 ps-2 mb-2" placeholder="Pesquisar por Tipo de operaçao, responsavel, Armagen" id="PesquisarMuvemento">
            </div>
            <div class="btn-toolbar mb-2 mb-md-0 ms-3">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary ontemHoje" dia="{{date('d')}}">Hoje</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary ontemHoje" dia="{{date('d')-1}}">Ontem </button>
                </div>
                <button type="date" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownMenuButton">
                    <span data-feather="calendar" id="datas" class="align-text-bottom">Intervalo</span>
                    <div class="dropdown-menu bg-white opacity-5 p-2 shadow-lg" id="datasInterval"  aria-labelledby="datas">
                        <input type="date" name="dataInicio" id="dataInicio" class="form-control mt-2 p-1">
                        <input type="date" name="dataInicio" id="dataFin" class="form-control mt-2 p-1">
                        <input type="button" value="Validar" id="ValidaPorIntervalo" class="btn">
                    </div>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle ms-2" id="dropdownMenuButton">
                    <span data-feather="calendar" id="dropdownMenuButto" class="align-text-bottom">Selectiona</span>
                    <div class="dropdown-menu" id="porMes" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item">Esta semana</div>
                        <div class="dropdown-item">Este mes</div>
                        <div class="dropdown-item">Este ano</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="MuventosBaixo w-100 bg-white overflow-auto">
        <div class="d-flex bg-white titleMuvementos text-secondary border-bottom">
            <div class="w-25">Artigo</div>
            <div>Ref Orden</div>
            <div>Responsavel</div>
            <div>Quantidade</div>
            <div>Tipo de Operação</div>
            <div>Armagen</div>
            <div>Data</div>
        </div>
        <div class="ResultadoMuvementos">

        </div>
    </div>
</div>

<div class="ResultListPedidos position-absolute w-100 h-100 bg-white top-0"></div>
<script src="csss/Stock/muvementoStock.js"></script>






