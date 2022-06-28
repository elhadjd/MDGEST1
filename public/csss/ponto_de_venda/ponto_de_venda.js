
$(document).ready(function(){
// A dives escondidas


//==============================================================================


    // A clicar no botao lista de artigos
    $("#lista_de_artigos").click(function(){
        var app = $(this).attr("app")
        $(".lista_dos_produto").css('margin-top','50px')
        $.ajax({
            type : "GET",
            url : "/lista_dos_produtos",
            data : {
                app : app,
            },
            success : function(e){
                $(".lista_dos_produto").html(e)
                $(".lista_dos_produto").show()
                $(".info_orden").hide();
                $(".principal").hide()
                $(".ResultRetornos").hide();
            }
        });
    });

    $("#menu_ponto_principal").click(function(){
        $.ajax({
            type : "GET",
            url : "/menu_ponto_de_venda",
            success : function(data){
                $(".App").html(data)
                $(".info_orden").hide();
                $(".lista_dos_produto").hide()
                $(".ResultRetornos").hide();
                $(".BlocoCaixa").hide()
                $(".ListaDeSessoes").hide()
            }
        });
    });
    $(".opcoes").hide()
    // A trazer menu principal de ponto de venda
    $.ajax({
        type : "GET",
        url : "/menu_ponto_de_venda",
        success : function(data){
            $(".App").html(data)
        }
    });
// A clicar no menu relatorios
$(".ListRelatorios").toggle();
$("#relatorioPtVenda").click(function(){
    $(".ListRelatorios").toggle();
});
$(".ResultRetornos").hide();
// A ir na rota RElatorios
$(".Relatorios").click(function(){
    var tipo = $(this).text();
    $.ajax({
        type: "GET",
        url : "/Relatorios",
        data : {
            tipo : tipo,
        },
        success : function(data){
            $(".lista_dos_produto").hide()
            $(".info_orden").hide();
            $(".ListRelatorios").toggle();
            $(".principal").hide()
            $(".ResultRetornos").show();
            $(".ResultRetornos").html(data);
        }
    })
})

});

