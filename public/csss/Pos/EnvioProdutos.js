$(".formArtigo").click(function(){
    var IdProd = $(this).attr("value");
    $("#NumerosClicados").html("");
    $(".idss").html("");
    $.ajax({
        type : "GET",
        url : "/AdicionarProduto",
        data : {
            quantidade : 1,
            IdProd : IdProd,
        },
        success : function(e){
            $(".menssagem").show("fast");
            $(".menssagem").html(e);
            // A buscar o bloco encomenda
            $.ajax({
                type : "GET",
                url : "/buscarEncomenda",
                data : {
                    id_caixa : 1,
                    id_session : 1,
                    pos_ativo : $(".posAtivo").text(),
                },
                success : function(data){
                    $(".esquerdaCima").html(data)

                }
            });
        }
    });
});


// A clicar na div menssagem de negaçoes
$(".menssagem").click(function(){
    $(this).hide("fast");
});
