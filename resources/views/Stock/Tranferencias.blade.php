<link rel="stylesheet" href="/csss/Stock/Stock.css">
<div id="menssagem" class="position-fixed text-center bold zindex-1080"></div>
<div class="w-100">
    <div class="IdMuvemento">{{$IdTransferencia}}</div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">Transferencia</h5>
        </div>
        <div class="modal-body transferencias w-100 ">
            <div class="d-flex w-100">
                <div class="ArmagenPrincipal w-25">
                    <label for="InputPrincipal">Armagen Principal</label><br>
                    <input type="search" name="InputPrincipal" placeholder="Nome do armagen principal" id="InputPrincipal" >
                    <div class="ResultPrincipal w-25 position-absolute bg-white p-1 rounded border text-secondary h-100 overflow-auto shadow"></div>
                </div>
                <div class="Artigo ms-2 w-50">
                    <label for="InputArtigo">Artigo</label><br>
                    <input type="search" name="InputArtigo" placeholder="Artigo para transferir" id="InputArtigo">
                    <div class="ResultArtigo w-50 position-absolute bg-white p-1 rounded border text-secondary h-100 overflow-auto shadow"></div>
                </div>
                <div class="ArmagenDestino ms-2 w-25">
                    <label for="InputDestino">Armagen Destino</label><br>
                    <input type="search" name="InputDestino" placeholder="Nome do armagen do destino" id="InputDestino" >
                    <div class="ResultDestino w-25 position-absolute  p-1 rounded border text-secondary h-100 bg-white overflow-auto shadow"></div>
                </div>
            </div>
            <div class="d-flex w-100 mt-4">
                <div class="w-50 d-flex">
                    <h4 class="text-secondary"><strong>Stock Disponivel</strong></h4>
                    <span class="QuantidadeDisponivel border-bottom ms-3"></span>
                    <i class="fa fa-bar-chart border-bottom"></i>
                </div>
                <div class="w-50">
                    <input type="number" name="QuantidadeTrasfere" placeholder="Quantidade para ser transferido" id="QuantidadeTrasfere">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary FecharTransferencia" data-bs-dismiss="modal">Fechar</button>
            <button type="button" id="ConfirmarTransferencia" class="btn btn-primary">Confirmar</button>
          </div>
    </div>
</div>
<script src="csss/Stock/Transferencia.js"></script>
