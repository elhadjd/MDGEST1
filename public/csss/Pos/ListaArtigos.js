$.ajax({
    type : "GET",
    url : "/trager_produtos",
    data: {
        pesquisar : '',
    },
    success : function(e){
        $(".direitaBaixo").html(e)

        // A buscar o bloco encomenda
        $.ajax({
            type : "GET",
            url : "/buscarEncomenda",
            data : {
                id_caixa : 1,
                id_session : 1,
                pos_ativo : $(".posAtivo").html(),
                idEncomenda : '',
            },
            success : function(data){
                $(".esquerdaCima").html(data)
            }
        });
        $(".Recibo").hide()
        $(".pagamento").hide();
        $(".PagamentoEsquerda").click(function(){
            $.ajax({
                type : "GET",
                url : "/FormPagamento",
                success : function(data){
                    $(".pagamento").show();
                    $(".pagamento").html(data)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $.ajax({
                        type : "GET",
                        url : "/buscarEncomenda",
                        data : {
                            id_caixa : 1,
                            id_session : 1,
                            pos_ativo : $(".posAtivo").html(),
                            idEncomenda : '',
                        },
                        success : function(data){
                            $(".esquerdaCima").html(data)
                        }
                    });
                }
            });
        });
    },
})
$(".PagamentoEsquerda").mousedown(function(){
    $(this).css("color","white")
    $(this).css("background-color","#555")
});

$(".PagamentoEsquerda").click(function(){
    $(this).css("color","#777")
    $(this).css("background-color","white")
});

$(".PagamentoEsquerda").mouseenter(function(){
    $(this).css("color","white")
    $(this).css("background-color","#A3498B")
});
$(".PagamentoEsquerda").mouseout(function(){
    $(this).css("color","#777")
    $(this).css("background-color","white")
});
$("#PesquisarProduto").keyup(function(){
    var nome = $(this).val();
    if (nome.length <=1) {

    } else {
        $.ajax({
            type : "GET",
            url : "/trager_produtos",
            data: {
                pesquisar : nome,
            },
            success : function(e){
                $(".direitaBaixo").html(e)
            }
        });
    }
});
// A clicar nos postos
$(".pos").click(function(){
    var pos_ativo = $(this).text()
    // A buscar o bloco encomenda
    $.ajax({
        type : "GET",
        url : "/buscarEncomenda",
        data : {
            id_caixa : 1,
            id_session : 1,
            pos_ativo : pos_ativo,
            idEncomenda : '',
        },
        success : function(data){
            $(".esquerdaCima").html(data)
        }
    });
});

// A buscar a fatura
// $.ajax({
//     type : "GET",
//     url : "/BuscarFatura",
//     data : {
//         idEncomenda : 28,
//     },
//     success : function(e){
//         $(".Recibo").html(e)
//     }
// })
