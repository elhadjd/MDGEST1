// A cicar na lista de usuarios 
$("#usuarios_liste").click(function(){
    $.ajax({
        type : "GET",
        url : "/ListeUser",
        success : function(e){
            $(".app").html(e);
            $("#menu_config").hide();
        },
        error : function(data){
            $(".menssagem").html(data)
        }
    })
});