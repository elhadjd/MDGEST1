// A flicar no campo adicionar fornecedor

// const { replace } = require("lodash");

$("#select_fernecedor").click(function(){
    $(".dropdown-menu").show("slow");
    $("#nomes_fornecedor").css("margin-top","15px")
    $.ajax({
       type : "GET",
       url : "/pesquisar_fornecedor?pesquisar_frncd=",
       success: function(e){
        $("#result").css('margin-top','15px')
        $("#result").html(e);
       }
    });
});
/// A filtrar as pesquisa das ordens
$(".estadoss").click(function(){
    $("#lista_de_filtro").hide("fast")
    var coluna = $(this).attr("colun");
    if (coluna === 'dia') {

        var por_mes = $("#mes").val();
        var por_dia = $("#dia").val();
        var colun_mes = $(this).attr('mes');
        var valor = $("#por_valor_recebido").html();
        var tipo = $(this).attr("value");
        $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?tipo_por_psq="+tipo+"&colun_mes="+colun_mes+"&por_dia="+por_dia+"&por_mes="+por_mes+"&coluna="+coluna+"&valor="+valor);
    }else{
        var por_mes = ''
        var por_dia = ''
        var colun_mes = ''
        var valor = $("#por_valor_recebido").html();
        var tipo = $(this).attr("value");
        $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?tipo_por_psq="+tipo+"&colun_mes="+colun_mes+"&por_dia="+por_dia+"&por_mes="+por_mes+"&coluna="+coluna+"&valor="+valor);

    }
});

// Final do filtros


// A eliminar uma linha de produto pedido
$(".apagar").click(function(){
    var id_da_linha_click = $(this).attr("id");
    var id_orden = $(this).attr("value");
    $.ajax({
        type : "GET",
        url : "/apagar_linha_de_artigo_pedido",
        data:{
            id_orden : id_orden,
            id_da_linha_click:id_da_linha_click,
        },
        success : function(){
            $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_orden);
            $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?toda_lista");
        }
    });
});

// A tyrazer total da orden
$("#regular").click(function(){
    var id_orden = $(this).attr("value");
    $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_orden);
    $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?toda_lista");
});

// A clicar no botao ADD produto
$("#add_prod").click(function(){
    $("#lista_de_artigossss").show("slow")
    var id_orden = $(this).attr("value")
    $.ajax({
        type : "GET",
       url : "/add_produtos_pedido?id_orden="+id_orden,
       success : function(e){
        $(".list").load("/lista_dos_artigos?lista_artigos="+''+"&id_orden="+id_orden+"&id_linha="+e);
        $("#add_new_ordens").load("/add_new_orden?id_principal_orden="+id_orden);
        $("#idiss").html(e);
        $("#menssagem").show("fast");
        $("#menssagem").html(e);
       },
    });
});
$(".fecaho_lista_artigo").click(function(){
    $("#lista_de_artigossss").hide("slow")
});
$(".linhas_artigos").click(function(){
    var id_da_linha = $(this).attr("linha")
    var id_da_orden = $(this).attr("orden")
    var id_artigo = $(this).attr("id")
    $.ajax({
        type : "GET",
        url : "/adicionar_artigo?id_da_linha="+id_da_linha+"&id_da_orden="+id_da_orden+"&id_artigo="+id_artigo,
        success: function(){
            $("#add_new_ordens").load("/add_new_orden?id_principal_orden="+id_da_orden);
            $("#lista_de_artigossss").hide()
        }
    });
});

// A clicar na linha de pedido~~

$(".icone").click(function(){
    var id_da_linha = $(this).attr("value")
    var id_orden = $(this).attr("id_orden")
    $("#lista_de_artigossss").show("slow")
    $(".list").load("/lista_dos_artigos?lista_artigos="+''+"&id_orden="+id_orden+"&id_linha="+id_da_linha);
    $("#idiss").html(id_da_linha);
});



// A pesquisar o fornecedor desta encomenda
$("#pesquisar_fernecedor").keyup(function(){
    var nome_fornecedor = $(this).val();
    if (nome_fornecedor.length<=2) {

    }else{
        $.ajax({
        type : "GET",
        url : "/pesquisar_fornecedor?pesquisar_frncd="+nome_fornecedor,
        data : {
            nome_fornecedor : nome_fornecedor,
        },
        success : function(e){
            $("#result").html(e);
        }
    });
    }

});


// A fazer update os muvementos
$(".updatee").click(function(){
    $(this).focus();
    $(this).val('')
});

$(".updatee").keyup(function(){
    var tabela = 'novo_pedido_de_compra';
    var colun = $(this).attr("tipo");
    var numero = $(this).val();
    var id_da_linha = $(this).attr("id_linha");
    var id_orden = $("#nome_artigo").attr("id_orden")
    $.ajax({
        type : "GET",
        url : "/updat_linha_de_pedido",
        data : {
            id_orden : id_orden,
            tabela :tabela,
            colun :colun,
            numero :numero,
            id_da_linha : id_da_linha,
        },
        success: function(e){
            if (e.length<=0) {

            }else{
                $("#menssagem").html(e);
                $("#menssagem").show("fast");
            }
        }
    });
});

//A fechar a div menssagem
$("#menssagem").click(function(){
    $("#menssagem").hide("fast")
});


// A selectionar nome de fornecedor
$(".estadoss").click(function(){
    var id_do_fornecedor = $(this).attr("value");

    $.ajax({
        type : "GET",
        url : "/adicionar_fornecedor_na_orden_compras?id_do_fornecedor="+id_do_fornecedor,
        success :function(e){
             $("#add_new_ordens").load("/add_new_orden?id_principal_orden="+e);
        }
    })
});


// A fechar janela de nova orden
$("#fechar_janela_de_nova_orden").click(function(){
    $("#add_new_ordens").hide("slow")
    $(".icones").show();
    $("#filtro").show("fast")
    var id_da_linha_clicada = $(this).attr("value");
    $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?toda_lista");
});

// A clicar nos botoes de validaçao
$(".bataos").click(function(){
    var tipo_de_funçao = $(this).attr("value");
    var id_orden = $("#fechar_janela_de_nova_orden").attr("value");
    $.ajax({
        type: "GET",
        url : "/validacaoes_de_orden",
        data: {
            id_orden : id_orden,
            tipo_de_funçao : tipo_de_funçao,
        },
        success : function(){
            $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_orden);
        }
    });
});

// A validar orden de venda
$(".validar").click(function(){
    var id_orden = $("#fechar_janela_de_nova_orden").attr("value");
    var tipo_de_funçao = $(this).attr("value");
    $.ajax({
        type : "GET",
        url : "/validacaoes_de_orden",
        data : {
            id_orden : id_orden,
            tipo_de_funçao : tipo_de_funçao,
        },
        success : function(){
            $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_orden);
        }
    });
});

// A clicar no botao fazer pagamento
$(".add_pagamento").click(function(){
    var id_orden = $(this).attr("id");
    var table = 'listcompra';
    $.ajax({
        type : "GET",
        url : "/pagamentos",
        data : {
            id_orden : id_orden,
            table : table,
        },
        success : function(e){
            $("#div_pagamento").html(e)
        }
    });
});



// A clicar no botao criar fornecedore
$("#criar_fornece").click(function(){
        $(".espacho_fornecedor").hide();
        $.ajax({
        type: "GET",
        url : "/new_fornecedore?dados_fornecedor=1",
        success: function(e){
            $("#criar_fornecedor").html(e)
        }
        });

});

// A enviar dador de fornecedore no banco
$("#guardar_fornecedor").click(function(e){
    // event.preventDefault();

});
// A clicar para selectionar um armagen
$("#MonstrarArmagens").click(function(){
    $("#divArmagens").toggle();
})
$(".armagen").click(function(){
    event.preventDefault();
    var IdArmagen = $(this).attr('IdArmagen')
    var idOrden = $(this).attr('idord');
    $.ajax({
        type: "GET",
        url : "/ordens_de_compra",
        data : {
            idOrden : idOrden,
            IdArmagen : IdArmagen,
        },
        beforeSend : function(){
            $(".processar").show();
        },success : function(data){
            $(".processar").hide();
            $("#MonstrarArmagens").html($(this).text());
            $("#divArmagens").hide()
        }
    })
})
