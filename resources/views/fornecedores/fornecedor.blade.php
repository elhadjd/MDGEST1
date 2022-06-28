<form action=" {{Route('cadastrar_fornecedor')}} "  method="POST" enctype="multipart/form-data">  
    <div>
        <input class="d-none" name="id_frn" value="{{$id_fornecedor}}">
        <div class="d-flex">
          <div>
            <div id="label_imagem_func">
              <label for="imagem"  class="rounded float-left" id="edit_img">
                <i class="fa fa-edit" ></i>
                <input type="file" name="imagem" id="imagem">
              </label>
              <label id="tash_img">
                <i class="fa fa-trash" ></i>
              </label>
            </div>
            <label class="" id="imagem_funcionario">
              <img src="/imagem_fornecedor/{{$imagem}}"class="img-thumbnail"  id="id_input_img_forne">
            </label>
          </div>
          <div class="d-flex select_tipo_for">
            <label for="select_tipo_forne" class="w-50 mt-2 b-0 text-secondary"><strong>Tipo de fornecedore</strong></label>
            <select class="form-select-sm" name="tipo_fornecedor" aria-label=".form-select-sm example" id="select_tipo_forne">
              <option selected>Empresa</option>
              <option value="1">Individual</option>
            </select>
          </div>
        </div>
        <div class="form-row d-flex mt-5">
          <div class="col-md-4 mb-3">
            <label for="validationDefault01">nome</label>
            <input type="text" class="form-control" name="nome_frn" id="validationDefault01" placeholder="Nome" value="" >
          </div>
          <div class="col-md-4 mb-3">
            <label for="validationDefault02">Telefone</label>
            <input type="text" name="telefone_frn" class="form-control" id="validationDefault02" placeholder="Telefone" value="" >
          </div>
          <div class="col-md-4 mb-3">
            <label for="validationDefaultUsername">Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend2">@</span>
              </div>
              <input type="text" name="email_forn" class="form-control" id="validationDefaultUsername" placeholder="Email" aria-describedby="inputGroupPrepend2" >
            </div>
          </div>
        </div>
        <div class="form-row d-flex">
          <div class="col-md-6 mb-3">
            <label for="validationDefault03">Cidade</label>
            <input type="text" name="cidade_frn" class="form-control" id="validationDefault03" placeholder="Cidade" >
          </div>
          <div class="col-md-3 mb-3">
            <label for="validationDefault04">Rua</label>
            <input type="text" name="rua_frn" class="form-control" id="validationDefault04" placeholder="Rua" >
          </div>
          <div class="col-md-3 mb-3">
            <label for="validationDefault05">Nif</label>
            <input type="text" name="nif_frn" class="form-control" id="validationDefault05" placeholder="Nif" >
          </div>
        </div>
        <button class="btn btn-primary" id="guardar_fornecedor" type="submit">Guardar</button>
        <button class="btn btn-secondary" id="fechar_tela_novo_forn">Fechar</button>
    </div>  
  </form>  
    <script type="text/javascript" src="csss/novo_pedido_compra.js"></script>
    <script type="text/javascript" src="csss/src/jquery.form.js"></script>
    <script type="text/javascript" src="csss/src/jquery.event.submit.js"></script>
    <script type="text/javascript" src="csss/src/jquery.editor.js"></script>
    <script src="{{ asset('csss/src/jquery.form.css') }}" defer></script>
