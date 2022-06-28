
$(".form_select_acces").click(function(){
    var mostre_accsApp = $(this).attr('value');
    $("."+mostre_accsApp).toggle();
    // $(".dropdown-menu").toggle("fast").html("Bom dia")
});

$(".escrever_na_info_user").keyup(function(){
    var palavra = $(this).val();
    var id_user_bloco = $(".id_user").html();
    var table = $(this).attr("table");
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            id_user_bloco : id_user_bloco,
            palavra : palavra,
            table : table
        },
        success : function(e){

        },
        error : function(e){
            console.Console(e)
        }
    });
});

// A manda senha no banco de dado
$(".ko_mintun").keyup(function(){
    var id_user_bloco = $(".id_user").html();
    var table = $(this).attr("table");
    var ko_mintun = $(this).val();
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            id_user_bloco : id_user_bloco,
            table : table,
            ko_mintun : ko_mintun
        },
    });
});

//  A enviar genero e estado civil no banco
$(".select_estado_civil").click(function(){
    $(".estado_civil").toggle("fast");
});
$(".select_genero").click(function(){
    $(".generos").toggle("fast");
});

$(".estado_genero").click(function(){
    var id_usuario = $(".id_user").html();
    var coluna = $(this).attr("coluna");
    var estado_genero = $(this).html();
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            estado_genero : estado_genero,
            coluna : coluna,
            id_usuario : id_usuario
        },
        success : function(){
            if (coluna == 'estado_civil') {
                $(".estado_civil").toggle("fast");
                $(".select_estado_civil").html(estado_genero)
            }else{
                $(".generos").toggle("fast");
                $(".select_genero").html(estado_genero)
            }
        }
    });

})


// A mandar accesso no banco de dados
$(".acces").click(function(){
    var tipoAcces = $(this).html();
    var idUser = $(".id_user").html();
    var IdApp = $(this).attr('value');
    $.ajax({
       type : "GET",
       url : "/accessApp",
        data : {
            tipoAcces : tipoAcces,
            idUser : idUser,
            IdApp : IdApp,
        },
        success : function(){
            $(".resultado_info").load("/info_user_creat?id_user="+idUser+"&tipo=Acesso")
        }
    });
});
