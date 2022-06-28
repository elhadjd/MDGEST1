$(".ListRelatorios").hide();
$("#relatorioPtVenda").click(function(){
    $(".ListRelatorios").toggle();
})

$.ajax({
    type: "GET",
    url: "/MenuStock",
    success: function(e){
        $(".App").html(e)
    }
})

$("#menu_ponto_principal").click(function(){
    $.ajax({
        type: "GET",
        url: "/MenuStock",
        success: function(e){
            $(".App").html(e)
        }
    })
})

$("#Armagens").click(function(){
    $.ajax({
        type: "GET",
        url: "/Armagens",
        success: function(e){
            $(".App").html(e)
        }
    })
})

$("#lista_de_artigos").click(function(){
    $.ajax({
        type: "GET",
        url: "/lista_dos_produtos",
        beforeSend : function(){
            $(".processar").show();
        },
        success: function(e){
            $(".App").html(e)
            $(".processar").hide();
        }
    })
})

$(".processar").hide();
// A clicar nos relatorios
$(".Relatorios").click(function(){
    var tipoOperation = $(this).text();
    $.ajax({
        type : "GET",
        url : "/RelatoriosStock",
        data : {
            tipoOperation : tipoOperation,
        },
        beforeSend : function(){
            $(".processar").show();
        },
        success : function(data){
            $(".processar").hide();
            $(".App").html(data)
            $(".ListRelatorios").toggle()
        }
    })
})

