$(".processar").hide();
$(".BlocoGasto").hide();
$(".AdicionarGastos").click(function(){
    $.ajax({
        type : "GET",
        url : "/AdicionarGasto",
        beforeSend : function(){
            $(".processar").show();
            $(".MenssagemProcesso").html('Aguarda por favor ');
        },
        success : function(data){
            var objet = JSON.parse(data)
            $(".processar").hide();
            $(".BlocoGasto").show();
            $(".IdGasto").html(objet.idGasto)
            $(".responsavel").html(objet.Responsavel)
        }
    })
})
// a buscar a lista dos gastos
$.ajax({
    type : "GET",
    url : "/AdicionarGasto",
    data : {
        lista : 'tudo',
    },beforeSend : function(){
        $(".processar").show();
        $(".MenssagemProcesso").html('Aguarda por favor ');
    },
    success : function(data){
        $(".ListaOrden").html(data)
        $(".processar").hide();
    }
});

// A pesquisar um gasto pelo data
$("#PesquuisarGasto").keyup(function(){
    if ($(this).val().length <=1) {
        var lista = 'tudo';
    } else {
        var lista = $(this).val();
    }
    $.ajax({
        type : "GET",
        url : "/AdicionarGasto",
        data : {
            lista : lista,
        },
        success : function(data){
            $(".ListaOrden").html(data)
            $(".processar").hide();
        }
    });
})


$(".facharJanela").click(function(){
    var IdGasto = $(".IdGasto").text()
    $.ajax({
        type : "GET",
        url : "/AdicionarGasto",
        data : {
            IdGasto :IdGasto,
            cancelar : 'cancelar',
        },
        success : function(data){
            $(".BlocoGasto").hide()
        }
    });
})

// a confirmar gasto
$(".ConfirmarGasto").click(function(){
    var IdGasto = $(".IdGasto").text()
    var assunto = $("#Assunto").val();
    var valor = $("#ValorGasto").val()
    if(IdGasto == ''){
        $(".menssagem").show()
        $(".menssagem").html("Erro do sistema por favor tenta novamente1");
    }else{
        if (assunto == '') {
            $(".menssagem").css("background-color","red");
            $(".menssagem").css("color","white");
            $(".menssagem").css("padding","15px");
            $(".menssagem").show()
            $(".menssagem").html("Atenção o campo assunto não pode ficar vazio !!!");
        }else{
            if (valor.length <=0) {
                $(".menssagem").show()
                $(".menssagem").css("background-color","red");
                $(".menssagem").css("color","white");
                $(".menssagem").css("padding","15px");
                $(".menssagem").html("Atenção o campo valor não pode ficar vaizio !!!");
            }else{
                $(".menssagem").hide()
                $.ajax({
                    type : "GET",
                    url : "/AdicionarGasto",
                    data : {
                        IdGasto : IdGasto,
                        assunto : assunto,
                        valor : valor,
                    }, beforeSend : function(){
                        $(".processar").show();
                        $(".MenssagemProcesso").html('Aguarda por favor ');
                    },
                    success : function(){
                        $(".processar").hide();
                        $(".BlocoGasto").show();
                        $(".BlocoGasto").hide();
                        $.ajax({
                            type : "GET",
                            url : "/AdicionarGasto",
                            data : {
                                lista : 'tudo',
                            },
                            beforeSend : function(){
                                $(".processar").show();
                                $(".MenssagemProcesso").html('Aguarda por favor ');
                            },
                            success : function(data){
                                $(".ListaOrden").html(data)
                                $(".processar").hide();
                            }
                        });
                    }
                })
            }
        }
    }
})
