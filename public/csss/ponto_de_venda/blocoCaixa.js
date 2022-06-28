$(".select_user").click(function(){
    $(".lista_user_para_shop").toggle();
})
// A criar caixa no banco de dados
$(".FormCaixaClick").click(function(){
    var tabela = $(this).attr('tabela')
    var coluna = $(this).attr('coluna')
    var idCaixa = $(this).attr('idCaixa');
    var usuario = $(this).text();
    if (coluna == 'impresao') {
        var asunto = $("#imprsaoAutomatico").is(':checked')
        console.log(asunto)
    } else {
        if (coluna == 'impresaoCliente') {
            var asunto = $("#impresaoCliente").is(':checked')
            console.log(asunto)
        } else {
            var asunto = $(this).attr('idUser');
        }
    }
    $.ajax({
        type : "GET",
        url : "/CriarCaixa",
        data : {
            idCaixa : idCaixa,
            tabela :tabela,
            coluna : coluna,
            asunto : asunto,
        },
        success : function(data){
            if (data.length > 1) {
                $(".lista_user_para_shop").hide()
                $(".menssagem").show();
                $(".menssagem").html(data);
                $(".ListArmagen").hide()
            }else{
                if(coluna == 'id_user_relation'){
                    $(".ListArmagen").hide()
                    $(".select_user").html(usuario)
                    $(".selectArmagen").html(usuario)
                    $(".lista_user_para_shop").hide()
                }
            }
        }
    });
})

// A esconder a div menssagem
$(".menssagem").click(function(){
    $(".menssagem").hide("fast")
})

$(".btnGuardar").click(function(){
    $(".BlocoCaixa").hide("fast")
});


 // A mandar nome da caioxa no banco
  $("#NomeCash").keyup(function(){
    var tabela = $(this).attr('tabela')
    var coluna = $(this).attr('coluna')
    var asunto = $(this).val();
    var idCaixa = $(this).attr('idCaixa');
    $.ajax({
        type : "GET",
        url : "/CriarCaixa",
        data : {
            tabela :tabela,
            coluna : coluna,
            asunto : asunto,
            idCaixa : idCaixa
        },
        success : function(data){
        }
    });
  })

$(".selectArmagen").click(function(){
    $(".ListArmagen").toggle();
})
checado = true;
$("#imprsaoAutomatico").click(function(){
    var checado = $("#imprsaoAutomatico").is(':checked')

})
