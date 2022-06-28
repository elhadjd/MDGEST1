$(".bloco_usere").click(function(){
    var id_user = $(this).attr('id_user')
    $.ajax({
        type : "GET",
        url : "/bloco_usuario?id_user="+id_user,
        success : function(e){
            $("#list_usder").hide();
            $(".div_bloco_usuario").html(e)
        }
    });
});

// A fechar a janela menssagem

$("#menssagem").click(function(){
    $(this).hide("fast")
});
