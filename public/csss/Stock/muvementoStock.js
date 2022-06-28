
// a buscar a lista dos muvementos
$.ajax({
    type: "GET",
    url : "/BuscarMuvementosStock",
    data : {
        lista : 'Toda',
    },
    success : function(data){
        $(".ResultadoMuvementos").html(data)
    }
})
// A trazer muvementos por datas
$(".ontemHoje").click(function(){
    var dia = $(this).attr("dia");
    $.ajax({
        type: "GET",
        url : "/BuscarMuvementosStock",
        data : {
            coluna : 'dia',
            lista : dia,
        },
        beforeSend : function(){
            $(".processar").show();
        },
        success : function(data){
            $(".processar").hide();
            $(".ResultadoMuvementos").html(data)
        }
    })
})

$("#PesquisarMuvemento").keyup(function(){
    $.ajax({
        type: "GET",
        url : "/BuscarMuvementosStock",
        data : {
            lista : $(this).val(),
        },
        success : function(data){
            $(".processar").hide();
            $(".ResultadoMuvementos").html(data)
        }
    })
})

$(".ResultListPedidos").hide();
$("#add_new_ordens").hide();


// A crear Uma transferencia
$(".FormTranferencia").hide()
$(".CrearTransferencia").click(function(){
    $.ajax({
        type: "GET",
        url : "/RelatoriosStock",
        data : {
            lista : 'CrearTransferencia',
        },
        beforeSend : function(){
            $(".processar").show();
        },
        success : function(data){
            $(".processar").hide();
            $(".FormTranferencia").html(data)
            $(".FormTranferencia").show()
        }
    })
})

