$(".FormArmagen").hide();
$(".IdArmagen").show()
$(".FormArmagen").submit(function(){
    event.preventDefault()
    var nomeArmagem = $("#NomeArmagen").val();
    var CidadeArmagen = $("#CidadeArmagen").val()
    var SedeArmagen = $("#SedeArmagen").val()
    var Edificio = $("#Edificio").val()
    $.ajax({
        type : "GET",
        url : '/GuardarArmagen',
        data : {
            SedeArmagen :SedeArmagen,
            CidadeArmagen : CidadeArmagen,
            nomeArmagem: nomeArmagem,
            Edificio : Edificio,
            Armagem : $(".IdArmagen").text(),
        },
        success : function(response){
            $(".FormArmagen").hide();
            $.ajax({
                type: "GET",
                url: "/Armagens",
                success: function(e){
                    $(".App").html(e)
                }
            })
        },
        Error : function(e){
            console.log(e)
        }
    })

})

$(".stockDisponivel").click(function(){
    var IdArmagen = $(this).attr('IdArmagen')
    $.ajax({
        type: "GET",
        url: "/MenuStock",
        data : {
            IdArmagen : IdArmagen,
        },
        beforeSend : function(){
            $(".processar").show();
        },
        success: function(e){
            $(".processar").hide();
            $(".ResultadoStock").show();
            $(".ResultadoStock").html(e)
        }
    })
})
$(".ResultadoStock").hide();

$(".NovoArmagen").click(function(){
    $.ajax({
        type : "GET",
        url : '/GuardarArmagen',
        data : {
            Armagem : 'Novo',
        },
        success : function(response){
            $(".FormArmagen").show();
            $(".IdArmagen").html(response)
        },
        Error : function(e){
            console.log(e)
        }
    })
})


$(".NomeArmagen").click(function(){
    var IdArmagem = $(this).attr('idArmagen');
    $.ajax({
        dataType : JSON,
        type : "GET",
        url : '/GuardarArmagen',
        data : {
            IdArmagem : IdArmagem,
        },
        success : function(response){
            var data = JSON.parse(response);
            $(".FormArmagen").show();
            $("#NomeArmagen").val(data.nome)
            $(".IdArmagen").html(IdArmagem)
        },
        Error : function(e){
            console.log(e)
        }
    })
})
