
// A clicar no botao criar caixa
 $(".CriarCaixa").click(function(){
    var IdAdmin = $("#user_conectado").attr("value");
    $.ajax({
        type : "GET",
        url : "/bloco_caixa",
        data : {
            IdAdmin : IdAdmin,
        },
        success : function(data){
            $(".BlocoCaixa").show("fast");
            $(".BlocoCaixa").html(data);
            $(".BlocoCaixa").show("fast");
        }
    });
 });
// A dives escondidas
// Div de bloco caixa
$(".BlocoCaixa").hide();
$(".opcoes").hide();
$(".fa-bars").click(function(){
    var clicado = $(this).attr("id");
    $("."+clicado).toggle("fast");
});


//==============================================================================





// A clicar no botao abrir controlo
$(".BotoesCaixa").click(function(){
    var TipoBotao = $(this).html();
    var id_caixa = $(this).attr('id_caixa');
    if (TipoBotao !='Continuar') {
        $.ajax({
            type : "GET",
            url : "/FormularioSession",
            data : {
                id_caixa : id_caixa
            },
            success: function(data){
                $(".FormSessions").html(data)
            }
        });
    }else{

    }
});
// A ir no grande pos
$(".Continuar").click(function(){
    var id_caixa = $(this).attr("id_caixa");
    $.ajax({
       type : "GET",
       url : "/HeaderPos",
       data : {
        id_caixa : id_caixa,
       },
       success : function(){
           window.location.href = "/Pos";
       }
    });
})

// A clicar nos opcoes da caixa
$(".divesOpcoes").click(function(){
    var opçao = $(this).text();
    var id_caixa = $(this).attr("id_caixa");
    if(opçao == 'Sessões'){
        $.ajax({
           type : "GET",
           url : "/SessoesCaixa",
           data : {
            id_caixa : id_caixa,
           },
           success : function(data){
            $(".ListaDeSessoes").html(data)
            $(".ListaDeSessoes").show();
           }
        });
    }else{
        if(opçao == 'Definições'){
            $.ajax({
                type : "GET",
                url : "/bloco_caixa",
                data : {
                    id_caixa : id_caixa,
                },
                success : function(data){
                    $(".BlocoCaixa").html(data);
                    $(".BlocoCaixa").show("fast");
                }
            });
        }

    }
});
$(".ListaDeSessoes").hide();
$(".ResultRetornos").hide();
