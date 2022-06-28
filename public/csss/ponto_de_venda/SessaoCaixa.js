$(".botoesCaixa").click(function(){
    var tipo = $(this).text();
    var idSession = $(this).attr('idSession');
    var abertura = $("#aberturaInput").val();
    if (tipo == 'Abrir controlo') {
        $.ajax({
            type : "GET",
            url : "/AbrirControloCaixa",
            data : {
                abertura : abertura,
                tipo : tipo,
                idSession : idSession
            },
            success : function(){
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
            }
        });
    } else {
        if (tipo == 'Fechar') {
            var valorEnformado = $("#velorEnformado").val();
            if (valorEnformado.length < 1) {
                $("#velorEnformado").css("border","1px solid red")
            } else {
                var total = $("#totalValor").text().replace('Kz','');
                $.ajax({
                    type : "GET",
                    url : "/FecharSession",
                    data : {
                        valorEnformado : valorEnformado,
                        total : total,
                        idSession : idSession
                    },
                    beforeSend : function(){
                        $(".processar").show();
                        $(".MenssagemProcesso").html('A fecar controlo aguarde por favor !!! ');
                    },
                    success : function(data){
                        $(".processar").hide();
                        $(".menssagem").show()
                        $(".menssagem").html(data)
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

                    }
                });
            }
        } else {

        }
    }
});

// A esconder a div menssagem
$(".menssagem").click(function(){
    $(".menssagem").hide("fast")
})
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
