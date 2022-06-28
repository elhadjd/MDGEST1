$(document).ready(function(){
    $(".Esconder").hide();
    $(".MostrarLista").click(function(){
        var idLinha = $(this).attr('idLinha');
        $("."+idLinha).toggle()
    })
    $(".TipoMuve").click(function(){
        $(".ResultMuvementosProd").hide()
        $(".icones").show()
        $(".novo_produto").show()
        $(".novo_prod").show();
    })
})

