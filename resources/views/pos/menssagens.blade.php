<link rel="stylesheet" href="/csss/Pos/pos.css">
<div class="BlocoSMS">
    <div>
        <div class="Menssagens">

        </div>
        <div class="InputSms">
            <div>
                <form method="GET" id="Form" IdPrin="{{$user->id}}" IdEnvi="{{$destino->id}} ">
                    @csrf
                    <textarea name="sms" id="InputSms"></textarea>
                    <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // A buscar as menssagens
    setInterval(() => {
        var idEnvio = $("#Form").attr('IdEnvi')
        $.ajax({
            type : "GET",
            url : "/menssagens",
            data : {
                novas : 'novas',
                IdUser : idEnvio,
            },
            success : function(data){
                $(".Menssagens").html(data)
            }
        })
    }, 1500);
    // A fazer submit
    $("#Form").submit(function(){
        event.preventDefault();
        var menssagen = $("#InputSms").val();
        var idPrincipal = $(this).attr('IdPrin');
        var idEnvio = $(this).attr('IdEnvi');
        $.ajax({
            type: "GET",
            url: "/menssagens",
            data : {
                menssagen : menssagen,
                idPrincipal : idPrincipal,
                idEnvio : idEnvio,
            },
            success : function(){
                $("#InputSms").val('')
                var idEnvio = $("#Form").attr('IdEnvi')
                $.ajax({
                    type : "GET",
                    url : "/menssagens",
                    data : {
                        novas : 'novas',
                        IdUser : idEnvio,
                    },
                    success : function(data){
                        $(".Menssagens").html(data)
                    }
                })
            }
        });
    })
</script>
