<div class="position-absolute menssagem top-0"></div>
@foreach ($artigos as $produtos)
    <label for="" value="{{$produtos->id}}" class="formArtigo" >
        <div style="height: 122px;width: 125px;">
            <div>
                <div class="PrecoProd">
                    <i class="fa fa-info-circle"></i>
                    <div id="ProdutoPreco">{{Number_format($produtos->preçovenda,2,",",".")."Kz"}}</div>
                </div>
                <div class="ProdutoImagem">
                    <img src="/storage/produtos/{{$produtos->imagem}}" alt="" srcset="">
                </div>
                <div class="ProdutoNome">{{$produtos->nome}}</div>
            </div>
        </div>
    </label>
@endforeach
<script src="csss/Pos/EnvioProdutos.js"></script>
