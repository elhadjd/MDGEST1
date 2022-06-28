

// A clicar nas informaçoes de usuario
$(".info_user").click(function(){
    var tipo = $(this).html();
    var id_user = $(this).attr('id_user');
    $(".info_user").css("background-color","#f9f9f9f9")
    $(this).css("background-color","#eee");
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            id_user : id_user,
            tipo : tipo
        },
        success : function(e){
            $(".resultado_info").html(e)
        }
    });
});
// A mostrar açao do formulario
$("#action").click(function(){
    $("#ActioShow").toggle("fast");
});
// A muvementar açoes de usuario
$(".actions").click(function(){
    var TipoAção = $(this).html();
    var id_user = $(this).attr('coluna')
    if (TipoAção != 'Apagar') {
        $.ajax({
            type : "GET",
            url : "/AcoesUser",
            contentType: false,
            processData: true,
            data : {
                TipoAção : TipoAção,
                id_user : id_user,
            },
            success : function(data){
                $("#menssagem").show()
                $("#menssagem").html(data);
                $(".div_bloco_usuario").load("/bloco_usuario?id_user="+id_user);
            }
        });
    }else{
        $(".modal").show("fast")
        $(".ClossModal").click(function(){
            $(".modal").hide("fast");
        });
    }
});

// A fechar a janela menssagem

$("#menssagem").click(function(){
    $(this).hide("fast")
});

// A eliminar usuario

$(".ApagarUser").click(function(){
    var TipoAção = "Apagar";
    var id_user = $(this).attr('coluna')
    $.ajax({
        type : "GET",
        url : "/AcoesUser",
        contentType: false,
        processData: true,
        data : {
            TipoAção : TipoAção,
            id_user : id_user,
        },
        success : function(data){
            $("#menssagem").show()
            $("#menssagem").html(data);
            $(".app").load("/ListeUser");
        }
    });
});



// A manda apelido nome completo email no banco
$(".escrever_nome_email").keyup(function(){
    var id_bloco_usere = $(".id_bloco_usere").html();
    var coluna = $(this).attr("coluna");
    var escrever_nome_email = $(this).val();
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            id_bloco_usere : id_bloco_usere,
            coluna : coluna,
            escrever_nome_email : escrever_nome_email
        },
    });
});

// A inserir accesso de usuario
$(".access").click(function(){
    var nivel = $(this).html();
    var id_bloco_usere = $(".id_bloco_usere").html();
    var coluna = $(this).attr("coluna");
    $.ajax({
        type : "GET",
        url : "/info_user_creat",
        data : {
            id_bloco_usere : id_bloco_usere,
            coluna : coluna,
            nivel : nivel
        },
        success : function(){
            $(".nivels").toggle();
            $("#dropdownMenuLink").html(nivel)
        }
    });
});


$("#dropdownMenuLink").click(function(){
    $(".nivels").toggle();
});
