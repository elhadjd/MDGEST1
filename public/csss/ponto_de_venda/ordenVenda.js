$("#por_estado_da_fatura").hide();
  $("#por_tipo_de_pagamento").hide();
  $("#por_ultilizadore").hide();
  $("#por_cliente").hide();
$("#por_estado_da_faturas").click(function(){
  $("#por_estado_da_fatura").toggle("slow")
  $("#por_tipo_de_pagamento").hide("slow");
  $("#por_ultilizadore").hide("slow");
  $("#por_cliente").hide("slow");
});
$("#por_tipo_de_pagamentos").click(function(){
  $("#por_tipo_de_pagamento").toggle("slow")
  $("#por_ultilizadore").hide("slow");
  $("#por_cliente").hide("slow");
  $("#por_estado_da_fatura").hide("slow");
});
$("#por_ultilizadores").click(function(){
  $("#por_ultilizadore").toggle("slow")
  $("#por_estado_da_fatura").hide("slow");
  $("#por_tipo_de_pagamento").hide("slow");
  $("#por_cliente").hide("slow");
});
$("#por_clientes").click(function(){
  $("#por_cliente").toggle("slow");
  $("#por_ultilizadore").hide("slow")
  $("#por_estado_da_fatura").hide("slow");
  $("#por_tipo_de_pagamento").hide("slow");
});
$("#por_data").hide()
$("#por_datase").click(function(){
  $("#por_data").toggle("slow");
});

// A pesquisar ordens
$("#PesquisarOrden").keyup(function(){
    var IdOrden = $(this).val();
    if (IdOrden.length <=1) {

    } else {
        $.ajax({
            type : "GET",
            url : "/BuscarOrden",
            data : {
                IdOrden : IdOrden,
            },
            success : function(data){
                $(".ListaOrden").html(data)
            }
        });
    }
})


// A pesquisar as orden de vendas
$.ajax({
    type : "GET",
    url : "/BuscarOrden",
    data : {
        IdOrden : '',
    },
    success : function(data){
        $(".ListaOrden").html(data)
    }
})
$(".ListAgrupar").hide()
$("#Agroupar").click(function(){
    $(".ListAgrupar").toggle()
})

// A pesquisar po estado da futura
$(".agrupar").click(function(){
    var table = $(this).attr('table');
    var coluna = $(this).attr('value');
    var tipo = $(this).text();
    $.ajax({
        type : "GET",
        url : "/BuscarOrden",
        data : {
            table : table,
            coluna : coluna,
            tipo : tipo
        },
        success : function(data){
            $(".ListaOrden").html(data)
        }
    })
})
