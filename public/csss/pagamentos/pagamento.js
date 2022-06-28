
$(".methodos").click(function(){
    $(".methodos").css("background-color","white")
    $(".methodos").css("color","#666")
    $(this).css("background-color","rgba(98, 148, 255, 0.945)")
    $(this).css("color","white")
    var tipo = $(this).attr("tipos");
    $("#tipo_pag").html(tipo)
});

$(".pagar").click(function(){
    var a_pagar = $(".a_pagar").html().replace('.','').replace(',','.').replace('Kz','');
    var table_a_enviar = $(this).attr("table");
    var table_a_tirar = 'listcompra';
    var id_orden = $(this).attr("id_orden");
    var valor_enformado = $("#digite_valor").val();
    var method = $("#tipo_pag").html();
    $.ajax({
        type : "GET",
        url : "/fazer_pagamento",
        data : {
            method : method,
            id_orden : id_orden,
            table_a_enviar : table_a_enviar,
            table_a_tirar : table_a_tirar,
            a_pagar : a_pagar,
            valor_enformado : valor_enformado,
        },success : function(e){
            $("#menssagem").html(e)
            $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_orden);
        }
    });
});
$(".pagamento_show").hide();
$(".lista_de_orden").click(function(){
    var orden = $(this).attr("id_orden");
    $("."+orden).toggle("fast")
    var ordens = orden.replace('Orden0','');
    $.ajax({
        type : "GET",
        url : "/buscar_pagamentos",
        data : {
            pagamento_id : ordens,
        },
        success : function(e){
            $("."+orden).html(e);
        }
    })
});

$(".add_pag").click(function(){
    alert("clicou")
    $("#add_new_ordens").show();
    $(".pagamentos").hide();
    $(".icones").hide("fast")
    $(".lista_dos_produtoss").hide()
    $(".info_orden").show();
    $("#filtro").hide("fast")
    var id_da_linha_clicada = $(this).attr("id");
    $("#add_new_ordens").load("add_new_orden?id_principal_orden="+id_da_linha_clicada);
});


// A pesquisar pagamento 
$("#pesquisar_pagamento").keyup(function(){
    var num_orden = $(this).val();
    if (num_orden != '') {
        $.ajax({
            type : "GET",
            url : "/buscar_pagamentos",
            data : {
                num_orden : num_orden
            },
            success : function(data){
                $(".lista_dos_pagamentos").html(data)
            }
        });
    }else{
    }
});
