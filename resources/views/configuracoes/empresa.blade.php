<div class="w-100 h-100 form-control mt-5">
    <div>
        <title>Empresa</title>
        <div class="text-secondary text-center mt-3"><h3><strong>Empresa</strong></h3></div>
        <div class="form-control w-100 h-75">
            @foreach ($empresas as $empresa)
            <label for="empresa_bloco" class="form-control bloco_de_empresa">
                <div class="d-flex">
                    <div>
                        @if ($empresa->imagem == "")
                        <div class="img-thumbnail text-secondary icone_empresa">
                            <i class="fa fa-building-o" aria-hidden="true"></i>
                        </div>
                        @else
                        <img src="" alt="">
                        @endif
                    </div>
                    <div class="mt-2 text-secondary mx-2">
                        <span><strong>Empresa : </strong> {{mb_strimwidth($empresa->nome_de_empresa,0,17).".."}} </span>
                        <span><strong>Cidade : </strong> {{$empresa->cidade}} </span><br>
                        <span><strong>Sede : </strong> {{$empresa->sede}} </span><br>
                        <span><strong>Nif : </strong> {{$empresa->nif_empresa}} </span>
                    </div>
                </div>
            </label>
            @endforeach
        </div>
    </div>
</div>