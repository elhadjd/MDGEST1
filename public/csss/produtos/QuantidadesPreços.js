
// A pesquisa artigo para detalhar
$("#NomeArtigo").keyup(function(){
    var NomeArtigo = $(this).val();
    $("#ResultadoPesqusa").css('padding','1%')
    var idPrincipal = $(this).attr('idPrin')
    if (NomeArtigo.length <=0) {
        $("#ResultadoPesqusa").css('width','25%')
        $("#ResultadoPesqusa").css('margin-left','0%')
        $("#ResultadoPesqusa").css('margin-top','1px')
    } else {
        $("#ResultadoPesqusa").css('width','50%')
        $("#ResultadoPesqusa").css('margin-top','30px')
        $("#ResultadoPesqusa").css('margin-left','-25%')
    }
    $.ajax({
        type : "GET",
        url: "/DetalharArtigo",
        data : {
            idPrincipal : idPrincipal,
            NomeArtigo : NomeArtigo,
        },
        success : function(data){
            $("#ResultadoPesqusa").html(data);
        }
    })
})
// A mandar as quantidades no banco de dados
$(".QuantidadeDetalho").keyup(function(){
    var idPrin = $(this).attr('idLinha');
    var coluna = $(this).attr('coluna')
    var value = $(this).val()
    $.ajax({
        type : "GET",
        url : "/DetalharArtigo",
        data : {
            idPrin : idPrin,
            coluna : coluna,
            value : value
        },
        success : function(){

        }
    })
})

// A fechar a janela
$(".fecharJanela").click(function(){
    $(".resultMuv").hide()
});

// A eliminar o artigo no detalho
$(".EliminarDetalho").click(function(){
    var idLinha = $(this).attr('idLinha');
    $.ajax({
        type : "GET",
        url: "/DetalharArtigo",
        data : {
            idLinha : idLinha,
            Elimina : 'Elimina',
        },
        success : function(data){
            $(".resultMuv").hide()
        }
    })
})
