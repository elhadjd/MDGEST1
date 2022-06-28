<div class="w-100 h-100">
    <div class="h-100 w-100">
        <div class="p-3 ListStockCima w-100">
            <title>Armagens</title>
            <h3 class="text-secondary"><strong>Armagens</strong></h3>
            <div class="d-flex w-100">


            </div>
        </div>
        <div class="position-absolute w-100">
            <form class="w-50 bg-white FormArmagen shadow rounded " method="GET">
                <div class="IdArmagen"></div>
                @csrf
                <h3 class="text-center p-1"><strong>Armagen</strong></h3>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="w-100  p-3">
                    <div class="form-group mb-2">
                        <label for="inputAddress2">Nome do Armagen</label>
                        <input type="text" class="form-control col-md-12" name="NomeArmagen" id="NomeArmagen" placeholder="Nome do armagen">
                    </div>
                    <div class="form-row mt-2 d-flex">
                        <div class="form-group col-md-4">
                            <label for="inputCity">Cidade</label>
                            <input type="text" class="form-control" name="CidadeArmagen" placeholder="Cidade" id="CidadeArmagen">
                        </div>
                        <div class="form-group ms-1 col-md-4">
                            <label for="inputState">Sede</label>
                            <input type="text" class="form-control" name="SedeArmagen" placeholder="Sede da empresa" id="SedeArmagen">
                        </div>
                        <div class="form-group ms-1 col-md-4">
                            <label for="inputZip">Nº Edificio</label>
                            <input type="text" class="form-control" name="Edificio" placeholder="Numero de edificio" id="Edificio">
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="btn btn-danger">Eliminar</div>
                        <button type="submit" class=" guardarArmagem">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class=" w-100 ListStockBaixo bg-white overflow-auto">
            <div class="w-100 p-2 border-bottom">
                <button class="NovoArmagen">Criar Armagen</button>
            </div>
            <div class="w-100 ListaArmagens bg-white text-secondary">
                <div class="d-flex titelArmagens border-bottom">
                    <div class="w-25">Nome do armagen</div>
                    <div class="w-25">Cidade</div>
                    <div class="w-25">Sede</div>
                    <div class="w-25">Edificio</div>
                </div>
                @foreach ($Armagens as $armagen)
                    <div class="d-flex w-100 ArmagensList NomeArmagen" idArmagen="{{$armagen->id}}">
                        <div class="w-25">{{$armagen->NomeArmagen}}</div>
                        <div class="w-25">{{$armagen->Cidade}}</div>
                        <div class="w-25">{{$armagen->Bairo}}</div>
                        <div class="w-25">{{$armagen->NumeroCasa}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="csss/Stock/Armagem.js"></script>
