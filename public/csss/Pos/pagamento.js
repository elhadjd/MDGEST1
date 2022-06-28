// A mudar a cor de botao clicado

$(".tecladoNumeros").click(function(){
    $(".tecladoNumeros").css('background-color','#f9f9f9f9')
    $(".tecladoNumeros").css('color','#777')
})
$(".tecladoNumeros").mousedown(function(){
    $(this).css('background-color','black');
    $(this).css('color','white');
});
$(".tecladoNumeros").mouseover(function(){
    $(this).css('background-color','white');
});
$(".tecladoNumeros").mouseout(function(){
    $(".tecladoNumeros").css('background-color','#f9f9f9f9')
});

// A clicar nos botoes de numeros
// A esconder a div validar
$("#ValidarPagamento").hide()

    $(".tecladoNumeros").click(function(){
        $(".TotalEncomendas").hide()
    $(".CalculoTotal").show();
        $(".CalculoTotal").show();
        var Mthod = $("#ValorNums").html()
        var num = $(this).text().replace(' ','');
        var numero = $('.'+Mthod).html();
        $('.'+Mthod).html(numero + num);
        $("#ValorNums").css('background-color','white')

        // A fazer calculo do tutal da fatura
        var TotalFatura = $(".TotalEncomendas").text();

        $("#TotalCompra").html(TotalFatura);

        var Entreg = $('.'+Mthod).text();

        var Entregue = Number($(".Multicaixa").text()) + Number($(".Numerario").text()) + Number($(".Transferencia").text())

// A mendar troco de cliente na div
$("#TrocoCliente").html(numeral(0).format('0,0')+",00Kz")


        var resto = TotalFatura.replace('.','').replace('00Kz','').replace(',','') - Entregue;
        var restos = numeral(Number(resto)).format('0,0')+",00Kz";
        $("#restoAPagar").html(restos);
        // A VERIFICAR SE JA ESTA POSITIVO
        if (resto <=0) {
            $("#restoAPagar").html(numeral(0).format('0,0')+",00Kz")
            // A mendar troco de cliente na div
        $("#TrocoCliente").html(numeral(resto).format('0,0')+",00Kz")
        // A mostrar div validar pagamento
        $("#ValidarPagamento").show("fast")
        }


    })

    // A eliminar ultimo numero
$("#TiraNumeros").click(function(){
    var method = $("#ValorNums").html()
    var num = $('.'+method).html()
    var numero = num.substring(0, num.length - 1)
    $('.'+method).html(numero);



    // A fazer calculo do tutal da fatura
    var TotalFatura = $(".TotalEncomendas").text();

    $("#TotalCompra").html(TotalFatura);

    var Entregue = Number($(".Multicaixa").text()) + Number($(".Numerario").text()) + Number($(".Transferencia").text())


    var resto = TotalFatura.replace('.','').replace('00Kz','').replace(',','') - Entregue;
    var restos = numeral(Number(resto)).format('0,0')+",00Kz";
    $("#restoAPagar").html(restos);
    // A VERIFICAR SE JA ESTA POSITIVO
    if (resto <=0) {
        $("#restoAPagar").html(numeral(0).format('0,0')+",00Kz")
        // A mendar troco de cliente na div
        $("#TrocoCliente").html(numeral(resto).format('0,0')+",00Kz")
        //a mostrar div validar pagamento
        $("#ValidarPagamento").show("fast")
    }else{
        // A mendar troco de cliente na div
        $("#TrocoCliente").html(numeral(0).format('0,0')+",00Kz")
        // A esconder a div validar pagamento
        $("#ValidarPagamento").hide("fast")
    }
})

// A esconder o calcolu de total
$(".CalculoTotal").hide();


// A selectionar o method de pagamento

$(".methodo").click(function(){
    var Method = $(this).attr('nomeMthod');
    $("#ValorNums").html(Method)
    $(".methodo").css('background-color','rgb(241, 241, 241)')
    $(this).css('background-color','white')
    $(".TotalEncomendas").hide()
    if ($(".ValorEntregue").html() == '') {
        $(".TotalEncomendas").show()
        $(".CalculoTotal").hide();
    }else{
        $(".TotalEncomendas").hide()
        $(".CalculoTotal").show();
    }
})

// A clicar no botoes Dinheiro pegado
$(".NumerosPegado").click(function(){
    $(".NumerosPegado").css('background-color','#f9f9f9f9')
    $(".NumerosPegado").css('color','#777')


    // A mandar dineiro nos methodos
    var Mthod = $("#ValorNums").html();
    var num = Number($(this).text().replace(' ',''));
    var numero = Number($('.'+Mthod).html());
    var total = num + numero;
    $('.'+Mthod).html(total);
    $(".TotalEncomendas").hide()
    $(".CalculoTotal").show();

    // A fazer calculo do tutal da fatura
    var TotalFatura = $(".TotalEncomendas").text();

    $("#TotalCompra").html(TotalFatura);

    var Entregue = Number($(".Multicaixa").text()) + Number($(".Numerario").text()) + Number($(".Transferencia").text())


    var resto = TotalFatura.replace('.','').replace('00Kz','').replace(',','') - Entregue;
    var restos = numeral(Number(resto)).format('0,0')+",00Kz";
    $("#restoAPagar").html(restos);
    // A VERIFICAR SE JA ESTA POSITIVO
    if (resto <=0) {
        $("#restoAPagar").html(numeral(0).format('0,0')+",00Kz")
        // A mendar troco de cliente na div
        $("#TrocoCliente").html(numeral(resto).format('0,0')+",00Kz")
        //a mostrar div validar pagamento
        $("#ValidarPagamento").show("fast")
    }else{
        // A mendar troco de cliente na div
        $("#TrocoCliente").html(numeral(0).format('0,0')+",00Kz")
        // A esconder a div validar pagamento
        $("#ValidarPagamento").hide("fast")
    }

})

$(".NumerosPegado").mousedown(function(){
    $(this).css('background-color','black');
    $(this).css('color','white');
});
$(".NumerosPegado").mouseover(function(){
    $(this).css('background-color','white');
    $(".NumerosPegado").css('color','#777')
});
$(".NumerosPegado").mouseout(function(){
    $(".NumerosPegado").css('background-color','#f9f9f9f9')
    $(".NumerosPegado").css('color','#777')
});


// A canselar pagamento
$("#CanselarPagamento").click(function(){
    $(".pagamento").hide();
})


// A validar pagamento
$("#ValidarPagamento").click(function(){
    $.ajax({
        type: "GET",
        url : "/ValidarPagamento",
        data : {
            idIncomenda : $("#idIncomenda").text(),
            Numerario : Number($(".Numerario").text()),
            Multicaixa : Number($(".Multicaixa").text()),
            Transferencia : Number($(".Transferencia").text()),
            TipoFatura : $(".success").text(),
        },
        success : function(e){
            console.log(e)
            window.location.href = "/BuscarFatura?idEncomenda="+$("#idIncomenda").text();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $(".menssagem").html(xhr.responseText);
        }
    })
})
// A criar  sission da fatura
$(".Faturas").click(function(){
    $(this).css('background-color','white');
    $(this).css('color','#777');
    $.ajax({
        type : "GET",
        url : '/BuscarFatura',
        data : {
            idIncomenda : $("#idIncomenda").text(),
        },
        success : function(data){
            $(".menssagem").show()
            var success = JSON.parse(data);
            $.each(success, function(id, item){
                if (item.success != 'Pronto pagamento') {
                    $(".menssagem").show()
                    $(".menssagem").html(item.menssagen)
                } else {
                    $(".menssagem").hide()
                    // A verificar se tipo esta vazio
                    if ($(".success").text()!='') {
                    } else {
                        $(".success").show();
                        $(".success").html(item.success)
                    }
                    $(".TipoFatura").toggle()
                }
            });
        }
    })
    //
})
$(".success").hide();
// A esconder tipo de fatura
$(".TipoFatura").hide()
// A clicar no tipo de fatura
$(".TipoFaturase").click(function(){
    if ($(this).text()!='Pronto pagamento ') {
        $("#ValidarPagamento").show("fast")
    } else {
        $("#ValidarPagamento").hide("fast")
    }
    $(".success").html($(this).text())
})
