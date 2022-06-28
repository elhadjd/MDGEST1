// A mostrar os inputest datas
$("#datas").click(function(){
    $("#datasInterval").toggle();
    $("#porMes").hide();
})

// A mostrar filtro por mes
$("#dropdownMenuButto").click(function(){
    $("#porMes").toggle();
    $("#datasInterval").hide();
})

// a pesquisar as encomendas pos
$("#PesquisarOrden").keyup(function(){
    var palavra = $("#PesquisarOrden").val()
    if (palavra == '') {
        palavra = 'lista';
    }
    $.ajax({
        type : "GET",
        url : "/BuscarRelatorio",
        data : {
            lista: palavra,
        },
        success : function(data){
            var objet = JSON.parse(data)
            $.each(objet, function(id, item){
                $('.listaEncomendasRelatorio').html(
                    '<div class="d-flex w-100 p-1 ListaEncomRelat border-bottom" id_orden="'+item.id+'">'+
                        '<div>'
                            +'Orden'+item.id+
                        '</div>'+
                        '<div>'+
                        item.caixa+
                        '</div>'+
                        '<div>'+
                        item.session+
                        '</div>'+
                        '<div>'+
                        item.funcionario+
                        '</div>'+
                        '<div>'+
                        item.total+
                        '</div>'+
                        '<div>'+
                        item.estado+
                        '</div>'+
                    '</div>');
            });
            $(".ListaEncomRelat").click(function(){
                var id_orden = $(this).attr('id_orden');
                $.ajax({
                    type : "GET",
                    url : "/ListPedido",
                    data : {
                        id_orden : id_orden,
                    },
                    success : function(data){
                        $(".ResultListPedidos").html(data)
                        $(".ResultListPedidos").show()
                    }
                });
            })
            // var TotalVendas = $.parseJSON(data)
            // $("#TotalVenda").html(TotalVendas.TotalDiario);
        }
    })
})



$.ajax({
    type : "GET",
    url : "/BuscarRelatorio",
    data : {
        lista: 'lista',
    },
    success : function(data){
        var objet = JSON.parse(data)
        $.each(objet, function(id, item){
            $('.listaEncomendasRelatorio').append(
                '<div class="d-flex w-100 p-1 ListaEncomRelat border-bottom" id_orden="'+item.id+'">'+
                    '<div>'
                        +'Orden'+item.id+
                    '</div>'+
                    '<div>'+
                    item.caixa+
                    '</div>'+
                    '<div>'+
                    item.session+
                    '</div>'+
                    '<div>'+
                    item.funcionario+
                    '</div>'+
                    '<div>'+
                    item.total+
                    '</div>'+
                    '<div>'+
                    item.estado+
                    '</div>'+
                '</div>');
        });
        $(".ListaEncomRelat").click(function(){
            var id_orden = $(this).attr('id_orden');
            $.ajax({
                type : "GET",
                url : "/ListPedido",
                data : {
                    id_orden : id_orden,
                },
                success : function(data){
                    $(".ResultListPedidos").html(data)
                    $(".ResultListPedidos").show()
                }
            });
        })
        // var TotalVendas = $.parseJSON(data)
        // $("#TotalVenda").html(TotalVendas.TotalDiario);
    }
})

$(".ResultListPedidos").hide()
setInterval(() => {
    $.ajax({
        type : "GET",
        url : "/BuscarRelatorio",
        success : function(data){
            var TotalVendas = $.parseJSON(data)
            $(".GastosDiarios").html(TotalVendas.Gastos)
            $(".TotalLucro").html(TotalVendas.TotalLucro)
            $("#TotalVenda").html(TotalVendas.TotalDiario);
        }
    })
}, 10000);

$(".VendidosLucro").click(function(){
    event.preventDefault();
    var table = $(this).attr('table')
    var tipo = $(this).attr('tipo');
    var coluna = $(this).attr('coluna')
    $.ajax({
        type : "GET",
        url : "/MuvementosProd",
        data: {
            tipo : tipo,
            table : table,
            coluna : coluna,
        },
        beforeSend : function(){
            $(".processar").show();
            $(".MenssagemProcesso").html('Aguarda por favor ');
        },
        success : function(data){
            $(".processar").hide();
            $(".ResultadoMovementosProd").css('height','100%')
            $(".ResultadoMovementosProd").html(data)
        }
    })
})


