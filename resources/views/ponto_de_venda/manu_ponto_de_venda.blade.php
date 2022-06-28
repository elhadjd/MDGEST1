<div class="MenuPontoDeVenda w-100" >
    <title>Ponto de venda</title>
    <div class="principal">
        <div class="mt-5 text-secondary"><h3><strong>Ponto de venda</strong></h3></div>
        <div class="BlocoCaixa position-absolute zindex-1080 w-100">
        </div>
        <div>
            <button class="btn CriarCaixa">Criar caixa</button>
        </div>
        <label class="form-control ListCaixas w-100 h-100">
            @foreach ($caixa as $caixas)
            <label class="FormCaixas shadow ">
                <div class="form-control w-100 d-flex FormCaixaCima text-secondary">
                    <div class="d-flex">
                        <div>{{$caixas->nome}}</div>
                        <div class="mx-2"><img src="/csss/configuarcoes/img_user/{{DB::table('tb_usuariolog')->where('id',$caixas->id_user_relation)->pluck('imagem')->first()}} " alt=""></div>
                    </div>
                    <div class="estado">{{$caixas->estado}}
                        @if (str_replace(' ','',$caixas->estado) =="Aberto")
                        <i class="fa fa-circle mx-2 text-success" aria-hidden="true"></i>
                        @elseif (str_replace(' ','',$caixas->estado) =="Aabrir")
                        <i class="fa fa-circle mx-2 text-info" aria-hidden="false"></i>
                        @else
                        <i class="fa fa-circle mx-2 text-danger" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div class="bars">
                        <i class="fa fa-bars" id="{{$caixas->id}}"></i>
                        <div class="{{$caixas->id}} opcoes rounded shadow">
                            <div class="divesOpcoes" id_caixa="{{$caixas->id}}">Ordens</div>
                            <div class="divesOpcoes" id_caixa="{{$caixas->id}}">Sessões</div>
                            <div class="divesOpcoes" id_caixa="{{$caixas->id}}">Definições</div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mx-3">
                    @if (str_replace(' ','',$caixas->estado) !="Aberto")
                    <div class="">
                        <div class="form-control BotoesCaixa AbrirControlo" id_caixa="{{$caixas->id}}">Abrir</div>
                    </div>
                    @else
                    <div class="d-flex">
                        <div class="form-control Continuar AbrirControlo" id_caixa="{{$caixas->id}}">Continuar</div>
                    </div>
                    @endif
                </div>
            </label>
            @endforeach
        </label>
        <div class="form-conteiner FormSessions w-100 position-absolute"></div>

    </div>
    <div class="ResultRetornos w-100 position-absolute h-100 top-0"></div>
    <div class="lista_dos_produto w-100"></div>
    <div class="ListaDeSessoes h-100"></div>
</div>
<script src="csss/ponto_de_venda/MenuPontoVenda.js"></script>
