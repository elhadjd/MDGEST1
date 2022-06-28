<div id="bloco_user_de_cima">
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <p>Desesa realment apagar este usuario !!!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary ClossModal" data-dismiss="modal">Fechar</button>
                <button type="button" coluna="{{$usuario->id}}" class="ApagarUser">Confirmar</button>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="bloco_user_de_baixo w-100">
    <div id="guardar_user" class="form-control w-100 d-flex">
        <div class="btnCriarGuardar">Guardar</div>
        <div class="btn btn-secondary mx-2">Fechar</div>
        <div class="dropdown" id="actionForm">
            <div class="form-select" id="action">
              Ação
            </div>
            <div class="dropdown-menu " id="ActioShow" aria-labelledby="ActioShow">
                @if (str_replace(' ','',$usuario->estado)!="Ativo")
                <div class="dropdown-item actions" coluna="{{$usuario->id}}">Restorar</div>
                @else
                <div class="dropdown-item actions" coluna="{{$usuario->id}}">Arquivar</div>
                @endif
              <div class="dropdown-item actions" coluna="{{$usuario->id}}">Apagar</div>
            </div>
        </div>
    </div>
    <div class="bloco_usuario">
        <form action="">
            <div class="d-none id_bloco_usere">{{$usuario->id}}</div>
            <div>
                <div class="form_user_de_cima d-flex">
                    <div class="form_nome_email text-secondary">
                        <div class="d-flex">
                            <label for="apelido" class=" mx-2">Apelido</label>
                            <input type="text" name="apelido" placeholder="Apelido" coluna="apelido" id="apelido"
                             class="w-50 escrever_nome_email form-control mx-3" value="{{$usuario->apelido}}">
                            <div class="dropdown show w-50">
                                <div class="form-select" id="dropdownMenuLink" >
                                  @if ($usuario->nivel == '')
                                      {{'Nivel'}}
                                  @else
                                      {{$usuario->nivel}}
                                  @endif
                                </div>

                                <div class="dropdown-menu nivels" aria-labelledby="dropdownMenuLink">
                                  <div class="dropdown-item access" coluna="nivel">Administrador</div>
                                  <div class="dropdown-item access" coluna="nivel">Gerente</div>
                                  <div class="dropdown-item access" coluna="nivel">Operador de caixa</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="nome_usere">Nome completo</label>
                            <input type="text" name="nome_usere" coluna="nome_completo" class="form-control escrever_nome_email" id="nome_usere" value="{{$usuario->nome_completo}}">
                        </div>
                        <div>
                            <label for="email_user">Email</label>
                            <input type="text" name="email_user" id="email_user" coluna="email" class="form-control escrever_nome_email" value="{{$usuario->email}}">
                        </div>
                    </div>
                    <div class="form_img_user">
                        <div id="form_img">
                            <div class="edit_img">
                                <label for="input_img">
                                    <input type="file" name="input_img" id="input_img" class="d-none">
                                    <i class="fa fa-edit"></i>
                                </label>
                                <span>
                                    <i class="fa fa-trash"></i>
                                </span>
                            </div>
                            <img src="/csss/configuarcoes/img_user/{{$usuario->imagem}}" class="rounded float-left" alt="...">
                        </div>
                    </div>
                </div>
                <div id="informacoes" class="d-flex text-info">
                    <div class="info_user" id_user="{{$usuario->id}}">Enformaçoes pesuais</div>
                    <div class="info_user" id_user="{{$usuario->id}}">Acesso</div>
                    <div class="info_user" id_user="{{$usuario->id}}">Senha</div>
                </div>
                {{-- Div da enformaçao de usuario --}}
                <div class="resultado_info">

                </div>
            </div>
        </form>
    </div>
</div>
<script src="csss/configuarcoes/bloco_user.js"></script>
