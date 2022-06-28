$(document).ready(function(){
    $("#lista_das_compra").click(function(){
        $(".pagamentos").hide();
        $(".lista_dos_produtoss").hide()
        $(".info_orden").show();
        $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?toda_lista");
    });
});

$(".linha_orden").click(function(){
    $("#add_new_ordens").show();
    $(".pagamentos").hide();
    $(".icones").hide("fast")
    $(".lista_dos_produtoss").hide()
    $(".info_orden").show();
    $("#filtro").hide("fast")

    var id_da_linha_clicada = $(this).attr("id");
    $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_da_linha_clicada);
});
$(".lista_dos_produtoss").hide()
// A clicar no botao lista de artigos
$("#lista_de_artigos").click(function(){
    var app = $(this).attr("app")
    $(".lista_dos_produtoss").show()
    $(".info_orden").hide();
    $(".pagamentos").hide();
    $.ajax({
        type : "GET",
        url : "/lista_dos_produtos",
        data : {
            app : app,
        },
        success : function(e){
            $(".lista_dos_produtoss").html(e)
            $("#pesqusar_prod").val("");
            $("#pesqusar_prod").focus();
        }
    });
});



$(document).ready(function(){
    $("#pesqusar_prod").keyup(function(){
        var palavra = $(this).val();
        var coluna = $(this).attr("colun");
        var tabela = $(this).attr("table")
        $.ajax({
            type : "GET",
            url: "/pesquisas",
            data : {
                palavra: palavra,
                coluna : coluna,
                tabela : tabela
            },
            success : function(e){
                $("#lista_dos_produtos").show();
                $(".lista_dos_artigos").html(e)
            }
        });
    });



    $(".bloco_artigo").click(function(){
        alert("esta fix")
    });

    $(".btncriar_artigo").click(function(){
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            success : function(e){
                $(".novo_prod").html(e)
            }
        });
    });


    // A trazer as enformaçoes de produto
    $(".info_prod").click(function(){
        var tipo_info = $(this).attr("tipo");
        $.ajax({
            type : "GET",
            url : "/enformacoes_prod",
            data : {
                tipo_info : tipo_info,
            },
            success: function(e){
                $("#information_prod").html(e)
            }
        });
    });

});



$("#criar_uma_compra").click(function(){
    $(".icones").hide();
    var id_responsavel = $("#user_conectado").attr("value");
    $.ajax({
        type: "GET",
        url: "/CriarOrdenDeCompra",
       data: {
        id_responsavel:id_responsavel,
       },
       success: function(e){
        $("#add_new_ordens").show();
           $("#add_new_ordens").load("add_new_orden?id_principal_orden="+e);
           console.log(e)
       },
       Error: function(i){
           console.log(i);
       }
    });
});




$("#pesquisar_prod").keyup(function(){
    var nome_artigo = $(this).val();
    var id_orden = $("#add_prod").attr("value");
    var id_linha = $("#idiss").html();
    if (nome_artigo.length<=2) {

    }else{
        $(".list").load("/lista_dos_artigos?lista_artigos="+nome_artigo+"&id_orden="+id_orden+"&id_linha="+id_linha);
    }
});

// // A buscar lista dos produtos
// $("#pesquisar_prod").keyup(function(){
//     var nome_artigo = $(this).val();
//     var id_orden = $("#add_prod").attr("value");
//     var id_linha = $("#idiss").html();
//     $.ajax({
//         type : "GET",
//         url : "/lista_dos_artigos?lista_artigos="+nome_artigo,
//         data: {
//             id_orden : id_orden,
//             id_linha : id_linha
//         },
//         success: function(e){
//             $(".list").html(e);
//         }
//     });
//     $(".linhas_artigos").click(function(){
//         var id_da_linha = $(this).attr("linha")
//         var id_da_orden = $(this).attr("orden")
//         var id_artigo = $(this).attr("id")
//         $.ajax({
//             type : "GET",
//             url : "/adicionar_artigo?id_da_linha="+id_da_linha+"&id_da_orden="+id_da_orden+"&id_artigo="+id_artigo,
//             success: function(){
//                 $("#add_new_ordens").load("/add_new_orden?id_principal_orden="+id_da_orden);
//                 $("#lista_de_artigo").hide()
//             }
//         });
//     });
// });

$("#lista_de_artigossss").hide()
// A clicar em uma linha de orden de compra
$("#add_new_ordens").hide();
$(".linha_orden").click(function(){
    $("#add_new_ordens").show();
    $(".icones").hide("fast")
    $("#filtro").hide("fast")
    var id_da_linha_clicada = $(this).attr("id");
    $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_da_linha_clicada);
});

$(".Usuario").hide();
$(".Use").click(function(){
    $(".Usuario").toggle();
});

$(".Sair").click(function(){
    $.ajax({
        type : "GET",
        url : "homes",
        data : {
            sair : 'sair',
        },
        success : function(data){
            alert (data)
            window.location.href = "/homes";
        }
    })
})


    // $(".espacho_fornecedor").hide();
    // $.ajax({
    // type: "GET",
    // url : "/new_fornecedore?dados_fornecedor=10",
    // success: function(e){
    //     $("#criar_fornecedor").hide()
    // }
    // });

    $("#guardar_fornecedor").click(function(e){
        // event.preventDefault();
    });

// A fazer filtros ///////////////////////////////////=========================================
$("#lista_de_filtro").hide()
$("#filtro_tit").click(function(){
    $(".icones").toggle("fast");
    $("#lista_de_filtro").toggle("fast")
    $("#por_totals").hide("fast");
    $("#estados").hide("fast");
})
$("#fornecedoress").hide();
$("#fornece").mouseenter(function(){
    $("#por_datas").hide("fast");
    $("#estados").hide("fast");
    $("#por_totals").hide("fast");
    $("#fornecedoress").show("fast");
    $("#fornecedoress").load("/pesquisar_fornecedor?pesquisar_frncd=");
});

$("#search_orden").keyup(function(){
    var palavra = $(this).val();
    $("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?pesquisar="+palavra);
});

$("#lista_orden_das_pesquisa").load("/lista_das_orden_pesquisas?toda_lista");

$("#por_datas").hide();
$("#por_datass").mouseenter(function(){
    $("#estados").hide("fast");
    $("#por_datas").show("fast");
    $("#por_totals").hide("fast");
    $("#fornecedoress").hide("fast");
});


$("#por_maiores").hide();
$("#por_maior").mouseenter(function(){
    $("#por_maiores").show("fast");
    $("#por_menores").hide("fast")
    $(".input_por_valor").val("");
    $("#por_eguais").hide("fast");
});

$("#por_menores").hide();
$("#por_menor").mouseenter(function(){
    $("#por_maiores").hide("fast");
    $("#por_menores").show("fast")
    $(".input_por_valor").val("");
    $("#por_eguais").hide("fast");
});
$("#por_eguais").hide();
$("#por_egual").mouseenter(function(){
    $("#por_maiores").hide("fast");
    $(".input_por_valor").val("");
    $("#por_menores").hide("fast");
    $("#por_eguais").show("fast");
});

$("#por_totals").hide();
$("#por_totais").mouseenter(function(){
    $("#estados").hide("fast");
    $("#por_datas").hide("fast");
    $("#fornecedoress").hide("fast");
    $(".input_por_valor").val("");
    $("#por_totals").show("fast");
});

$("#estados").hide();
$("#estado").mouseenter(function(){
    $("#fornecedoress").hide("fast");
    $("#por_datas").hide("fast");
    $("#estados").show("fast");
    $("#por_totals").hide("fast");
});

$(".input_por_valor").keyup(function(){
    var valor = $(this).val();
    if (!Number(valor)) {
        $("#menssagem").show("fast");
        $("#menssagem").html("Atençao tipo de numero não permetido "+valor+" Por favor evite esses!!!");
        $("#menssagem").css("background-color","red")
        $("#menssagem").css("color","white")
    }else{
        $("#por_valor_recebido").html(valor)
    }
});


// Final do filtros


//  A mostrar todos os pagamentos
$("#pagamentos_compras").click(function(){
    $(".lista_dos_produtoss").hide()
    $(".info_orden").hide();
    $(".pagamentos").show();
    $.ajax({
        type : "GET",
        url : "/buscar_pagamentos?nada",
        success : function(data){
            $(".pagamentos").html(data)
        }
    });
});
