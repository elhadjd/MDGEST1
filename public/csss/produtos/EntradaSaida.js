$("#MonstrarArmagens").click(function(){
    $("#divArmagens").toggle();
})
$(".armagen").click(function(){
    event.preventDefault();
    $("#MonstrarArmagens").html($(this).text());
    $("#IdArmagen").html($(this).attr('IdArmagen'))
    $("#divArmagens").hide()
})
//=========================== A mandar stock no banco de daos====================
$("#IdArmagen").hide()

$(".ConfirmarStock").click(function(){
    var IdArmagen = $("#IdArmagen").text();
    var quantidade = $(".QuantidadeDetalho").val();
    var idArtigo = $(this).attr('idArtigo');
    var tipoOper = $(this).attr('TipoOper');
    $.ajax({
        type : "GET",
        url : "/EntradaSaidaStock",
        data : {
            IdArmagen : IdArmagen,
            quantidade : quantidade,
            idArtigo: idArtigo,
            tipoOper : tipoOper
        },
        beforeSend : function(){
            $(".processar").show();
        },success : function(data){
            $.ajax({
                type : "GET",
                url : "/novo_produto",
                data : {
                    id_prod: idArtigo,
                },
                success : function(e){
                    $(".lista_dos_produtos").hide()
                    $(".processar").hide();
                    $(".menssagem").show();
                    $(".menssagem").html(data);
                    $(".novo_prod").html(e)
                }
            });
        }
    })
})
