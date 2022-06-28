

// A clicar numa linha de compra
$(".listaPedido").click(function(){
    $("#NumerosClicados").html("");
    $(".listaPedido").css("background-color","white")
    $(".listaPedido").css("color","#666")
    $(this).css("background-color","#A3498B")
    $(this).css("color","white")
    // A receber id da linha clicada
    var idLinha = $(this).attr('idLinha');
    $(".idss").html(idLinha);
});

// A remover os numeros da quantidade
$(".açoes").click(function(){
    $("#NumerosClicados").html("");
    var açao = $(this).attr('tipo');
    $(".TipoAcçao").html(açao);
});
