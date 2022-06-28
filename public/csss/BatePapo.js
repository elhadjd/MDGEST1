// A buscar as menssagen do ususario clicado
$(".proccessar").hide();
$(".UsuariosBatePapos").click(function(){
    var IdUser = $(this).attr("IdUser")
    $.ajax({
        type : "GET",
        url : "/menssagens",
        data : {
            IdUser : IdUser,
        },
        beforeSend : function(){
            $(".proccessar").show();
        },
        success : function(data){
            $(".blocoUsuarios").html(data)
            $(".proccessar").hide();
        }
    })
})

$(".logoEmpresaBatePapo").click(function(){
    $.ajax({
        type : "GET",
        url : "/menssagens",
        data : {
            BuscarUseresSms : 'BuscarUseresSms',
        },
        beforeSend : function(){
            $(".proccessar").show();
        },
        success : function(data){
            $(".blocoUsuarios").html(data)
            $(".proccessar").hide();
        }
    })
})
$(".alerta").click(function(){
    $(".alerta").hide();
})
$(".ResultadoBloco").hide();
$(".VenUserMenssagen").click(function(){
    $(".alerta").hide();
    $(".ResultadoBloco").toggle();
})
setInterval(() => {
    $.ajax({
        type : "GET",
        url : "/menssagens",
        data : {
            NumerosSms : '2',
        },
        success : function(data){
            $(".novasMenssagens").html(data)
        }
    })
}, 2000);

setInterval(() => {
    var IdUser = $(".UsuariosBatePapos").attr("IdUser")
    $.ajax({
        type : "GET",
        url : "/menssagens",
        data : {
            IdUser : IdUser,
            Alert : '2',
        },
        success : function(data){
            $(".alerta").show()
            $(".alerta").html(data)
        }
    })
}, 6000);
