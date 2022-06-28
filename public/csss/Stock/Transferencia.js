// A pesquisar o armagen principal
$(".ResultPrincipal").hide()
$("#InputPrincipal").keyup(function(){
    var IdTransferencia = $(".IdMuvemento").text();
    var tabela = 'armagens_models';
    var coluna = 'NomeArmagen';
    var palavra = $(this).val()
    $.ajax({
        type: "GET",
        url : "/RelatoriosStock",
        data : {
            palavra : palavra,
            IdTransferencia: IdTransferencia,
            tabela : tabela,
            coluna : coluna,
            lista : 'Pesqqquisar',
        },
        success : function(data){
            $(".ResultPrincipal").show()
            $(".ResultPrincipal").html(data)
        }
    })
})
$(".ResultArtigo").hide()
$("#InputArtigo").keyup(function(){
    var IdTransferencia = $(".IdMuvemento").text();
    var tabela = 'produtos';
    var coluna = 'nome';
    var palavra = $(this).val()
    $.ajax({
        type: "GET",
        url : "/RelatoriosStock",
        data : {
            palavra : palavra,
            IdTransferencia: IdTransferencia,
            tabela : tabela,
            coluna : coluna,
            lista : 'Pesqqquisar',
        },
        success : function(data){
            $(".ResultArtigo").show()
            $(".ResultArtigo").html(data)
        }
    })
})
$(".ResultDestino").hide()
$("#InputDestino").keyup(function(){
    var IdTransferencia = $(".IdMuvemento").text();
    var tabela = 'armagens_models1';
    var coluna = 'NomeArmagen';
    var palavra = $(this).val()
    $.ajax({
        type: "GET",
        url : "/RelatoriosStock",
        data : {
            palavra : palavra,
            IdTransferencia: IdTransferencia,
            tabela : tabela,
            coluna : coluna,
            lista : 'Pesqqquisar',
        },
        success : function(data){
            $(".ResultDestino").show()
            $(".ResultDestino").html(data)

        }
    })
})

// A confirmar a transferencia
$("#ConfirmarTransferencia").click(function(){
    var quantidadeTransfer = $("#QuantidadeTrasfere").val();
    var quantidadeDisponivel = $(".QuantidadeDisponivel").text()
    var IdTransferencia = $(".IdMuvemento").text();
    $.ajax({
        type: "GET",
        url : "/RelatoriosStock",
        data : {
            quantidadeDisponivel : quantidadeDisponivel,
            IdTransferencia: IdTransferencia,
            quantidadeTransfer : quantidadeTransfer,
            lista : 'ValidarTransferencia',
        },
        beforeSend : function(){
            $(".processar").show();
        },
        success : function(data){
            $(".processar").hide();
            $("#menssagem").show();
            $("#menssagem").html(data);
        }
    })
})
$("#menssagem").hide();
$("#menssagem").click(function(){
    $("#menssagem").hide();
});
// A fechar o blocos transferencia
$(".FecharTransferencia").click(function(){
    $(".FormTranferencia").hide()
})
$(".IdMuvemento").hide()
