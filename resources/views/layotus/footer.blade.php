
</body>
<style>
.footer_app{
    position: fixed;
    bottom: 0;
    z-index: 1080;
    text-align: center;
    font-weight: 800;
    font-size: 18px;
}
.footer_app img{
    width: 200px
}
.processar{
    background-color: #e0e0e04d;
}
.processar i{
    font-size: 50px;
    margin-top: 20%;
    color: #A3498B;
}
.menssagem{
    margin-top: 5%;
}
</style>
@section('footere')
<div class="menssagem w-100 position-fixed text-center bold zindex-1080"></div>
<div class="processar w-100 h-100 position-fixed top-0 text-center zindex-1080">
    <i class="fa fa-spinner fa-spin fa-0x" aria-hidden="true"></i>
    <div class="MenssagemProcesso text-info"></div>
</div>
<div class="form-control footer_app ">
    <img src="/storage/logo/logos.png" alt="" style="width: 30px">
    <img src="/storage/logo/logo.png" alt="">
</div>
@show
@yield('footer')
<script type="text/javascript" src="csss/jquery.min.js"></script>
<script type="text/javascript" src="csss/compras/script.js"></script>
<script src="csss/BatePapo.js"></script>
<script>
    $(".processar").hide();
    $(".menssagem").click(function(){
        $(".menssagem").hide();
    });
</script>
</body>
