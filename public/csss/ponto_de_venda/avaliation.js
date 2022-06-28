
// A pesquisar as orden de vendas
$.ajax({
    type : "GET",
    url : "/ArtigosAvaliation",
    data : {
        Idprod : '',
    },
    success : function(data){
        $(".ListaOrden").html(data)
    }
})
$(".novo_prod").hide();
// A pesquisar ordens
$("#PesquisarOrden").keyup(function(){
    var Idprod = $(this).val();
    if (Idprod.length <=1) {

    } else {
        $.ajax({
            type : "GET",
            url : "/ArtigosAvaliation",
            data : {
                Idprod : Idprod,
            },
            success : function(data){
                $(".ListaOrden").html(data)
            }
        });
    }
})
