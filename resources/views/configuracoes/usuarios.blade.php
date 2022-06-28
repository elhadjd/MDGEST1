<div class="div_bloco_usuario">
    <div id="list_usder">
        <div class="text-secondary text-center w-100 p-2 titlo_lista_de_user"><span><strong>Lista de usuarios</strong></span></div>
        <div class="d-flex">
            <div class="btnCriarGuardar bloco_usere" id_user="">
                <span>CRIAR</span>
            </div>

        </div>
        <div class="form-control w-100 p-1 form_lista_de_user">
            <div class="form-control list_para_cima w-100 d-flex text-secondary">
                <div class="w-25">Nome completo</div>
                <div>Apelido</div>
                <div>Email</div>
                <div>Empresa</div>
                <div>Ultima sessão</div>
            </div>
            <div class="form-control p-0 w-100 list_user_baixo">
                @foreach ($users as $user)
                <div class="d-flex list_users_baixo bloco_usere" id_user="{{$user->id}}">
                    <div class="w-25">{{$user->nome_completo}}</div>
                    <div>{{$user->apelido}}</div>
                    <div>{{$user->email}}</div>
                    <div>{{mb_strimwidth($empresa,0,25)."..."}}</div>
                    <div>{{$user->apelido}}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="csss/configuarcoes/user.js"></script>
