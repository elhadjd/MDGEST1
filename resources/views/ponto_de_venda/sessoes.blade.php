<div class="CamponentSessoes">
    <div>
        <Example></Example>
    </div>
    <div class="text secondary text-center mt-3"><h4><strong>Lista de sessões</strong></h4></div>
    <div class="form-control p-0 CamponentSessoesListe">
        <div class="d-flex text-secondary p-0 titlosSession">
            <div>Id da sessão</div>
            <div>Ponto de venda</div>
            <div>Responsavel</div>
            <div>Data de abertura</div>
            <div>Data de fecho</div>
            <div>Estado</div>
        </div>
        @foreach ($sessoes as $sessoes)
        <div class="d-flex ListeSessoes" idSession="{{$sessoes->id}} ">
            <div><strong>{{"Sessões00".Number_format($sessoes->id)}}</strong></div>
            <div>{{DB::table('caixas')->where('id',$sessoes->id_da_caixa)->pluck('nome')->first()}}</div>
            <div>{{DB::table('tb_usuariolog')->where('id',$sessoes->id_user_responsavel)->pluck('apelido')->first()}}</div>
            <div>{{$sessoes->created_at}}</div>
            <div>{{(date('d-m-Y à\s H:i:s',strtotime($sessoes->updated_at)))}}</div>
            @if (str_replace(' ','',$sessoes->estado)=="Aabrir")
            <div>
                <div class="rounded w-25 bg-warning text-white">{{$sessoes->estado}}</div>
            </div>
            @elseif(str_replace(' ','',$sessoes->estado)=="Fechado")
            <div class="d-flex">
                <div class="rounded w-50 text-white bg-success">{{$sessoes->estado}}<i class="fa fa-check mx-2"></i></div>
            </div>
            @else
            <div>
                <div class="rounded w-75 text-white bg-info">{{'Em progresso'}}<i class="fa fa-spinner fa-spin mx-2" aria-hidden="true"></i></div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
<script>
    $(".ListeSessoes").click(function(){
        var idSession = $(this).attr("idSession");
        $.ajax({
            type: "GET",
            url : "/SessoesCaixas",
            data : {
                idSession : idSession
            },
            success : function(data){
                $(".ListaDeSessoes").hide();
                $(".FormSessions").html(data)
            }
        });
    })
</script>
