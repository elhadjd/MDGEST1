<div>
    @if ($tipo_info == "Enformaçoes pesuais")
        <div>
            <div class="d-flex ">
                <div class="d-flex w-50">
                    <div class="d-block text-secondary" id="label_info">
                        <label for="pais">Pais</label><br>
                        <label for="cidade">Cidade</label><br>
                        <label for="sede">Sede</label><br>
                        <label for="edificio">Edificio</label>
                    </div>
                    <span id="linha"></span>
                    <div class="d-block" id="inputs_info">
                        <input type="text" table="pais" name="pais" id="pais" placeholder="Pais"
                        class="escrever_na_info_user" value="{{$info->pais}}"><br>
                        <input type="text" table="cidade" name="cidade" id="cidade" placeholder="Cidade"
                        class="escrever_na_info_user" value="{{$info->cidade}}"><br>
                        <input type="text" table="sede" name="sede" id="sede" placeholder="Sede"
                        class="escrever_na_info_user" value="{{$info->sede}}"><br>
                        <input type="text" table="edificio" name="edificio" id="edificio" placeholder="Edificio"
                         class="escrever_na_info_user" value="{{$info->edificio}}">
                    </div>
                </div>
                <div class="d-flex w-50">
                    <div class="d-block text-secondary" id="label_info">
                        <label for="telefone">Telefone <i class="fa fa-phone"></i></label><br>
                        <label for="genero">Genero</label><br>
                        <label for="estado_civil">Estado civil</label><br>
                        <label for="data_naicimento">Data de naicimento <i class="fa fa-date"></i></label>
                    </div>
                    <span id="linha"></span>
                    <div class="d-block" id="inputs_info">
                        <input type="text" table="telefone" name="pais" id="telefone" value="{{$info->telefone}}" class="escrever_na_info_user" placeholder="Telefone"><br>
                        <div class="dropdown show w-100">
                            <div class="form-select select_genero" id="dropdownMenuLink" >
                              @if ($info->genero == '')
                                  {{'Genero'}}
                              @else
                                  {{$info->genero}}
                              @endif
                            </div>

                            <div class="dropdown-menu generos w-100" aria-labelledby="dropdownMenuLink">
                              <div class="dropdown-item estado_genero" coluna="genero">Masculino</div>
                              <div class="dropdown-item estado_genero" coluna="genero">Feminina</div>
                            </div>
                        </div>
                        <div class="dropdown show w-100">
                            <div class="form-select select_estado_civil" id="dropdownMenuLink" >
                              @if ($info->estado_civil == '')
                                  {{'Estado civil'}}
                              @else
                                  {{$info->estado_civil}}
                              @endif
                            </div>

                            <div class="dropdown-menu estado_civil w-100" aria-labelledby="dropdownMenuLink">
                              <div class="dropdown-item estado_genero" coluna="estado_civil">Solteiro</div>
                              <div class="dropdown-item estado_genero" coluna="estado_civil">Casado</div>
                            </div>
                        </div>
                        <input type="date" name="data_de_naicimento" table="data_naicimento" value="{{$info->data_naicimento}}" class="escrever_na_info_user" id="data_naicimento" placeholder="data de naicimento">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none id_user">{{$user->id}}</div>
    @elseif($tipo_info == "Acesso")
        <div class="w-100 d-auto altura_da_form overflow-auto">
            @foreach ($app as $apps)
            <label class="d-flex form_tipo_acces mt-3 text-secondary">
                <div id="modolus" class="mt-1 w-100"><span><strong>{{$apps->app_name}}</strong></span></div>
                <div class="w-100">
                    <div class="form-select form_select_acces" value="{{$apps->id}}">
                    {{DB::table('acces_App')->where('id_modulo',$apps->id)
                    ->where('id_usuario',$user->id)->pluck('tipo_de_acesso')->first()}}
                    </div>
                    <div class="dropdown-menu w-25 mostre_accsApp {{$apps->id}} " id="mostre_accsApp">
                        <div class="dropdown-item acces" value="{{$apps->id}}"> </div>
                        <div class="dropdown-item acces" value="{{$apps->id}}">Administrador</div>
                        <div class="dropdown-item acces" value="{{$apps->id}}">Utilizadore</div>
                    </div>
                </div>
            </label>
            @endforeach
        </div>
        <div class="d-none id_user" >{{$user->id}}</div>
    @elseif($tipo_info == "Senha")
        <div class="mt-3">
            <title>Nova senha</title>
            <div class="text-secondary text-center mt-2"><h3><strong>Nova senha</strong></h3></div>
            <div class="form-control text-secondary ">
                <label for="nova_senha" class="mx-2">Senha</label>
                <input type="password" name="nova_senha" id="nova_senha" class="form-control ko_mintun " placeholder="Nova senha">
            </div>
        </div>
        <div class="d-none id_user">{{$user->id}}</div>
    @endif
</div>
<script src="csss/configuarcoes/info_user.js"></script>
