// A trazer o menu principal
$(document).ready(function(){
    var id_app = $(".id_app").html();
    $(".app").load("/config?id_app="+id_app+"&menu="+1)

// A cicar na lista de usuarios 
$("#usuarios_liste").click(function(){
    $.ajax({
        type : "GET",
        url : "/ListeUser",
        success : function(e){
            $(".app").html(e);
        },
        error : function(data){
            $(".menssagem").html(data)
            $("#menu_config").hide();
        }
    })
});

$("#empresa").click(function(){
    $("#menu_config").hide();
    var id_app = $(".id_app").html();
    $(".app").load("/config?id_app="+id_app+"&empresa="+1)
});




// A cicar configuraçoes 
$("#home").click(function(){
    $("#menu_config").hide();
    var id_app = $(".id_app").html();
    $(".app").load("/config?id_app="+id_app+"&menu="+1)
});
});