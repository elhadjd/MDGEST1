 // A selectionar um fornecedore por este artigo

 $("#select_fornecedor").click(function(){
    $(".dropdown-menu").toggle()
})
// A definir fornecedore deste produto
$(".inputs_info_prod").click(function(){
    var id_forn = $(this).attr("id_forn");
    var tipo_info = 'fornecedor';
    var id_prod = $(this).attr('id_prod');
    $.ajax({
        type : "GET",
        url : "/inserir_informacao_prod",
        data : {
            id_forn : id_forn,
            id_prod : id_prod,
        },
        success : function(e){
            $.ajax({
                type : "GET",
                url : "/enformacoes_prod",
                data : {
                    tipo_info : tipo_info,
                    id_prod : id_prod,
                },
                success: function(e){
                    $("#information_prod").html(e)
                }
            });
        }
    });
});

// definir desconto do produto
$(".lista_preco").keyup(function(){
    var escrita = $(this).val();
    var tabela = $(this).attr('table');
    var coluna = $(this).attr('coluna');
    var id_prod =$(this).attr('id_prod');
    var tipo_info = 'list_price';
    $.ajax({
        type : "GET",
        url : "/inserir_informacao_prod",
        data : {
            escrita : escrita,
            tabela : tabela,
            coluna : coluna,
            id_prod : id_prod,
            tipo_info : tipo_info
        },
        success : function(e){
        }
    });
});
$(".lista_preco").click(function(){
    var numero = $(this).val().replace(',00Unidade(s)','').replace(',00Kz','');
    $(this).val(numero)
});


// A buscar fornecedore pelo nome
$("#search_fornecedor_para_produto").keyup(function(){
    var nome_fornecedor = $(this).val();
    var tipo_info = $(this).attr("tipo");
    var id_prod = $(this).attr('id_prod');
    $.ajax({
        type : "GET",
        url : "/enformacoes_prod",
        data : {
            tipo_info : tipo_info,
            id_prod : id_prod,
            nome_fornecedor : nome_fornecedor,
        },
        success: function(e){
            $("#resultado_fonecedores").html(e)
        }
    });
});
$(".resultMuv").hide();
$(".Detalhar").click(function(){
    var id_prod = $(this).attr("value");
    $.ajax({
        type : "GET",
        url : "/DetalharArtigo",
        data : {
            id_prod: id_prod,
        },
        beforeSend : function(){
            $(".processar").show();
        },success : function(data){
            $(".resultMuv").show();
            $(".processar").hide();
            $(".resultMuv").html(data);

        }
    })
});

// A fazer entrada e saida
$(".EntraSai").click(function(){
    var id_prod = $(this).attr("value");
    var tipoOperation = $(this).text();
    $.ajax({
        type : "GET",
        url : "/EntradaSaidaStock",
        data : {
            tipo : 'TrazerBloco',
            tipoOperation : tipoOperation,
            id_prod: id_prod,
        },
        beforeSend : function(){
            $(".processar").show();
        },success : function(data){
            $(".resultMuv").show();
            $(".processar").hide();
            $(".resultMuv").html(data);

        }
    })
})
/// A enviar preços no banco
$(".input_info").keyup(function(){
    var preco = $(this).val();
    var coluna = $(this).attr('coluna');
    var id_prod = $("#inputs_informacao").attr("id_prod");
    var tipo_info = 'informacoes';
    $.ajax({
        type : "GET",
        url : "/inserir_informacao_prod",
        data : {
            preco : preco,
            coluna : coluna,
            id_prod : id_prod,
            tipo_info : tipo_info
        },
        success : function(e){
        }
    });
});
// A Ir buscar os muvementos deste artigo
$(".ResultMuvementosProd").hide()
$(".view_muvementos").click(function(){
    var idProdMuv = $(this).attr('value');
    $.ajax({
        type : "GET",
        url : "/DetalharArtigo",
        data : {
            tipoMuv : $(this).attr('tipoMuv'),
            idProdMuv : idProdMuv
        },
        beforeSend : function(){
            $(".MenssagemProcesso").html("Sistema a processar por favor aguarda !!!")
            $(".processar").show()
        },
        success : function(data){
            $(".processar").hide();
            $(".icones").hide();
            $(".ResultMuvementosProd").show()
            $(".ResultMuvementosProd").html(data)
        }
    })
})
