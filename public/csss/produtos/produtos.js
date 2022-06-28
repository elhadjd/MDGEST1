$(document).ready(function(){
    $("#pesqusar_prod").keyup(function(){
        var palavra = $(this).val();
        var coluna = $(this).attr("colun");
        var tabela = $(this).attr("table")
        if (palavra.length>=2) {
            $.ajax({
                type : "GET",
                url: "/pesquisas",
                data : {
                    palavra: palavra,
                    coluna : coluna,
                    tabela : tabela
                },
                success : function(e){
                    $("#lista_dos_produtos").show();
                    $(".lista_dos_artigose").html(e)
                }
            });
        }else{
        }
    });
    $(".guardar_produto").click(function(){
        event.preventDefault()
        $.ajax({
            type : "GET",
            url: "/pesquisas",
            data : {
                palavra: $("#pesqusar_prod").val(),
                coluna : 'nome',
                tabela : 'produtos'
            },
            success : function(e){
                $(".novo_produto").hide()
                $(".novo_prod").hide();
                $(".lista_dos_produtos").show("fast")
                $(".lista_dos_produtoss").html(e)
                $("#pesqusar_prod").focus();
            }
        });
        // $.ajax({
        //     type : "GET",
        //     url : "/lista_dos_produtos",
        //     data : {
        //         app : app,
        //     },
        //     success : function(e){
        //         $(".novo_produto").hide("fast")
        //         $(".novo_prod").hide("fast");
        //         $(".lista_dos_produtos").show("fast")
        //         $(".lista_dos_produtoss").html(e)
        //         $("#pesqusar_prod").val("");
        //         $("#pesqusar_prod").focus();
        //     }
        // });
    });

// A testar upload de imagem
// $("#FormNewProd").submit(function(even){
//     event.preventDefault();

// })



    $(".bloco_artigo").click(function(){
        var id_prod = $(this).attr('id_prod');
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            data : {
                id_prod: id_prod,
            },
            success : function(e){
                $(".novo_produto").show()
                $(".novo_prod").show();
                $(".lista_dos_produtos").hide()
                $(".novo_prod").html(e)
            }
        });
    });

    $(".btncriar_artigo").click(function(){
        $(".lista_dos_produtos").hide()
        $.ajax({
            type : "GET",
            url : "/novo_produto",
            success : function(e){
                $(".novo_prod").show("fast")
                $(".novo_prod").html(e)
            }
        });
    });



    // A trazer as enformaçoes de produto
    $(".info_prod").click(function(){
        var tipo_info = $(this).attr("tipo");
        var id_prod = $(this).attr('id_prod');
        $(".info_prod").css("background-color","white")
        $(this).css("background-color","#eeee")
        $.ajax({
            type : "GET",
            url : "/enformacoes_prod",
            data : {
                tipo_info : tipo_info,
                id_prod : id_prod,
            },
            success: function(e){
                $("#information_prod").html(e)
            }
        });
    });

    $(".nome_artigo_data").keyup(function(){
        var preco = $(this).val();
        var coluna = $(this).attr('coluna');
        var id_prod = $(this).attr("id_prod");
        $.ajax({
            type : "GET",
            url : "/inserir_informacao_prod",
            data : {
                preco : preco,
                coluna : coluna,
                id_prod : id_prod,
            },
            success : function(e){
            }
        });
    });

    $(".nome_artigo_data").change(function(){

    });
});

$(".processar").hide();
