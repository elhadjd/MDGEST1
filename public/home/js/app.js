
$(document).ready(function(){
    $(".menu_home").hide();
    $(".botao").click(function(){
        $(".menu_home").toggle("fast");
    });
    $(".name_app").click(function(){
        var id_app = $(this).attr('id_app');
        var app = $(this).attr('name_app');
        if (app == 'Compra ') {
            window.location.href = '/ordens_de_compra?toda_lista';
        }
        if (app == 'Ponto de venda ') {
            window.location.href = "/ponto_de_venda";
        }
        if (app == 'Configuraçoes ') {
            window.location.href = '/config?id_app='+id_app;
        }
        if (app == 'Stock ') {
            window.location.href = "/Stock";
        }
    })
});
