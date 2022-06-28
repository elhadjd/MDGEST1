<?php

namespace App\Http\Controllers;

use App\Models\ArmagensModel;
use App\Models\artigos_detalhados;
use App\Models\controloProdutosVendidos;
use App\Models\DataMuvementoModel;
use App\Models\lista_de_preco;
use App\Models\MarginProd;
use App\Models\produtos as ModelsProdutos;
use App\Models\ProdutosComprado;
use App\Models\Stock;
use App\Models\tb_usuariolog;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Util\HtmlElement;

class produtos extends Controller
{
    //

    public function product(ModelsProdutos $produtos)
    {
        $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
        $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        if ($user->nivel !='Administrador') {

        }else{
            return view('produtos',[
                'produtos'=>$produtos->all(),
                'user'=>$user->apelido,
            ]);
        }
    }
    public function lista_dos_produtos()
    {
        # code...
        $produtos = DB::table('produtos')->orderBy('nome','ASC')->paginate(30);
        $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        if ($user->nivel !='Administrador') {

        }else{
            return view('produtos.produtos',[
                'produtos'=>$produtos,
                'user'=>$user
            ]);
        }
    }
    public function pesquisas(Request $request)
    {
        #A pesquisar produto por nome
        $artigo = DB::table($request->get('tabela'))->where($request->get('coluna'),'LIKE','%'.$request->get('palavra').'%')->limit(10)->get();
        return view('pesquisas',[
            'produtos'=>$artigo,
        ]);
    }
    public function novo_produto(Request $request,ProdutosComprado $produtosComprado, controloProdutosVendidos $controloProdutosVendidos,MarginProd $marginProd)
    {
        if ($request->get('id_prod')) {
            $artigo = $request->get('id_prod');
        }else{
            $artigo = Db::table('produtos')->insertGetId([
                'imagem'=>'produto-sem-imagem.png',
            ]);
            $marginProd->id_prod = $artigo;
            $marginProd->save();
            $controloProdutosVendidos->idProd = $artigo;
            $controloProdutosVendidos->quantidade = 0;
            $controloProdutosVendidos->save();

            $produtosComprado->idProd = $artigo;
            $produtosComprado->quantidade = 0;
            $produtosComprado->save();
        }

        $produto = DB::table('produtos')->where('id',$artigo)->first();
        // A selectinar os muvementos de estock
        $muvemento = DB::table('muvementos_de_stock')->where('id_do_artigo',$artigo);
        $muvementos = $muvemento->count();
        $Entra = $muvemento->where('tipo_de_operacao','!=','Saida Pos')->where('tipo_de_operacao','!=','Saida')->sum('quantidade');
        $Saida = DB::table('muvementos_de_stock')->where('id_do_artigo',$artigo)->where('tipo_de_operacao','Saida Pos')->sum("quantidade");
        return view('produtos.novo_produto',[
            'produto'=>$produto,
            'movementos'=>$muvementos,
            'Saida'=>$Saida,
            'Entrada'=>$Entra,
        ]);
    }
    public function enformacoes_prod(Request $request)
    {
        $product = DB::table('produtos')->where('id',$request->get('id_prod'))->first();
        if ($request->get('tipo_info') == 'informacoes') {
            return view('produtos.enformaçoes',[
                'informacoes'=>$product,
            ]);
        }elseif ($request->get('tipo_info') == 'fornecedor') {
            if ($request->get('nome_fornecedor')) {
                $fornecedore = DB::table('fornecedores')->where('nome','LIKE','%'.$request->get('nome_fornecedor').'%')->get();
                foreach ($fornecedore  as $fornecedores) {
                    echo '<div id="div_nome_fornecedore" id_prod="'.$product->id.'" id_forn="'.$fornecedores->id.'"
                    class="inputs_info_prod" >'.$fornecedores->nome.'</div>';
                    ?>
                    <script>
                        $(".inputs_info_prod").click(function(){
                        var id_forn = $(this).attr("id_forn");
                        var tipo_info = 'fornecedor';
                        var id_prod = $(this).attr('id_prod');
                        $.ajax({
                            type : "GET",
                            url : "/inserir_informacao_prod",
                            data : {
                                id_forn : id_forn,
                                id_prod : id_prod,
                            },
                            success : function(e){
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
                            }
                        });
                    });
                    </script>
                    <?php
                }
            }else{
                $fornecedore = DB::table('fornecedores')->get();
            return view('produtos.enformaçoes',[
                'fornecedor'=>$product,
                'nome_for'=>$fornecedore
            ]);
        }
        }elseif ($request->get('tipo_info') == 'list_price') {
            return view('produtos.enformaçoes',[
                'list_price'=>$product,
            ]);
        }elseif ($request->get('tipo_info') == 'outro') {
            return view('produtos.enformaçoes',[
                'outro'=>$product,
            ]);
        }
    }

    public function inserir_informacao_prod(Request $request )
    {
        if ($request->get('preco')) {
            $preco = str_replace('.','',str_replace('Kz','',$request->get('preco')));
            $precos = str_replace(',','.',$preco);
            $insert_fornecedor = DB::table('produtos')->where('id',$request->get('id_prod'))->update([
                $request->get('coluna')=>$precos,
            ]);
            // A modificar o preço deste artigo na tabela margin deste produto
            if ($request->get('coluna') == 'preçocust') {
                $colun = 'PrecoCusto';
            } elseif($request->get('coluna') == 'preçovenda') {
                $colun = 'PrecoVenda';
            }
            DB::table('margin_prods')->where('id_prod',$request->get('id_prod'))->update([
                $colun=>$precos,
            ]);
            $margin = DB::table('margin_prods')->where('id_prod',$request->get('id_prod'))->first();
            DB::table('margin_prods')->where('id_prod',$request->get('id_prod'))->update([
                'margin'=>$margin->PrecoVenda - $margin->PrecoCusto,
            ]);

        }else{
            $insert_fornecedor = DB::table('produtos')->where('id',$request->get('id_prod'))->update([
                'fornecedore'=>$request->get('id_forn'),
            ]);
        }
        if ($request->get('tabela') == 'lista_de_preco') {

            $list = DB::table($request->get('tabela'))->where('id_produto',$request->get('id_prod'))->count();
            if ($list > 0) {
                $update = DB::table($request->get('tabela'))->where('id_produto',$request->get('id_prod'))->update([
                    $request->get('coluna')=>$request->get('escrita'),
                ]);
            }else{
                $data = date("Y-m-d H:m:i");
                $insert = DB::table($request->get('tabela'))->insertGetId([
                    'id_produto'=>$request->get('id_prod'),
                    'id_responsavel'=>session('id'),
                    'data'=>$data
                ]);
                $update = DB::table($request->get('tabela'))->where('id_produto',$request->get('id_prod'))->update([
                    $request->get('coluna')=>$request->get('escrita'),
                ]);
            }
        }
    }
    // A
    public function DetalharArtigo(Request $request, artigos_detalhados $artigos_detalhados)
    {
        if ($request->get('NomeArtigo')) {
            // a pesquisar produtos
            $pesquisar = DB::table('produtos')->where('nome','LIKE','%'.$request->get('NomeArtigo').'%')->get();
            for($i = 0; $i <sizeof($pesquisar); $i++){
                $resultado = $pesquisar[$i];
                $linha = DB::table('artigos_detalhados')->where('idArtigoPrincipal',$request->get('idPrincipal'))->first();
                echo '
                <div class="ResultadoProdutos" coluna="idArtigodetalhado" idLinha="'.$linha->id.'" IdArtigoPrincipal="'.$linha->idArtigoPrincipal.'" value="'.$resultado->id.'">
                    <div>'.$resultado->nome.'</div>
                </div>
                ';
            }
            ?>
            <script>
                // A dar umclick por cima de uma linha do resultado
                $(".ResultadoProdutos").click(function(){
                    var idPrin = $(this).attr('idLinha');
                    var coluna = $(this).attr('coluna')
                    var value = $(this).attr('value')
                    var id_prod = $(this).attr('IdArtigoPrincipal')
                    $.ajax({
                        type : "GET",
                        url : "/DetalharArtigo",
                        data : {
                            idPrin : idPrin,
                            coluna : coluna,
                            value : value
                        },
                        success : function(){
                            $.ajax({
                                type : "GET",
                                url : "/DetalharArtigo",
                                data : {
                                    id_prod: id_prod,
                                },
                                beforeSend : function(){
                                    $(".processar").show();
                                },success : function(data){
                                    $(".processar").hide();
                                    $(".resultMuv").html(data);
                                }
                            })
                        }
                    })
                });

            </script>
            <?php
        }
        elseif($request->get('idPrin')){
            // A inserir as infomaçoes no banco de dados
            if ($request->get('coluna') == 'QuantidadeTemporaria') {
                $linha = DB::table('artigos_detalhados')->where('id',$request->get('idPrin'))->first();
                if ($linha->QuantidadeTemporaria!='') {
                    $quantidade = $request->get('value') + str_replace('-','',$linha->QuantidadeTemporaria);
                } else {
                    $quantidade = $request->get('value');
                }

                $insert = DB::table('artigos_detalhados')->where('id',$request->get('idPrin'))->update([
                    $request->get('coluna') => "-".$quantidade
                ]);
            } else {
                $insert = DB::table('artigos_detalhados')->where('id',$request->get('idPrin'))->update([
                    $request->get('coluna') => $request->get('value')
                ]);
            }
        }elseif($request->get('Elimina')){
            DB::table('artigos_detalhados')->where('id',$request->get('idLinha'))->delete();
        } elseif ($request->get('tipoMuv')) {
            return view('produtos.muvementos',[
                'muv'=>DataMuvementoModel::all(),
                'IdProd'=>$request->get('idProdMuv'),
                'tipoMuv'=>$request->get('tipoMuv'),
            ]);

        }else {
            // A selectionar o artigo principaldddddddddddddddd
            $ArtigoPrincipal = DB::table('produtos')->where('id',$request->get('id_prod'))->first();
            // A selectionar o artigo corespondente ao id recebido
            $ArtigoDetalhado = DB::table('artigos_detalhados')->where('idArtigoPrincipal',$request->get('id_prod'));
            if ($ArtigoDetalhado->count()<=0) {
                $artigos_detalhados->idArtigoPrincipal = $request->get('id_prod');
                $artigos_detalhados->IdResponsavel = session('id_admin');
                $artigos_detalhados->save();
                $IdProd = $artigos_detalhados->id;
                $infos = $artigos_detalhados;
            }else{
                $IdProd = $ArtigoDetalhado->first()->id;
                $infos = $ArtigoDetalhado->first();
            }
            return view('produtos.FormDetalhoArtigos',[
                'idProd'=>$IdProd,
                'infos'=>$infos,
                'artigo'=>$ArtigoPrincipal,
            ]);
        }
    }
    // A fazer entrada e saida de stock
    public function EntradaSaidaStock(Request $request, Stock $stocks , ProdutosComprado $produtosComprado)
    {
        $dia = date("d");
            $mes = date("m");
            $anno = date("Y");
            if ($mes == '01') {
                $mes = 'Janeiro';
            }elseif($mes == '02'){
                $mes = 'Fevereiro';
            }elseif($mes == '03'){
                $mes = 'Março';
            }elseif($mes == '04'){
                $mes = 'Abril';
            }elseif($mes == '05'){
                $mes = 'Maio';
            }elseif($mes == '06'){
                $mes = 'Junho';
            }elseif($mes == '07'){
                $mes = 'Julho';
            }elseif($mes == '08'){
                $mes = 'Agosto';
            }elseif($mes == '09'){
                $mes = 'Setembro';
            }elseif($mes == '10'){
                $mes = 'Outobro';
            }elseif($mes == '11'){
                $mes = 'Novembro';
            }elseif($mes == '12'){
                $mes = 'Dezembro';
            }
            // A selectionar o armagen correspondente a este id recebido
            $armagen = DB::table('armagens_models')->where('id',$request->get('IdArmagen'))->first();
            if ($request->get('tipo') == 'TrazerBloco') {
            // A verificar o tipo de operaçáo
            $operation = $request->get('tipoOperation');
            // A selectionar todos os armagens
            $armage = ArmagensModel::all();
            // A selectionar o artigo correspondente
            $artigo = DB::table('produtos')->where('id',$request->get('id_prod'))->first();
            // A somar stock deste artigo nos armagens
            $tock = DB::table('stocks')->where('IdArtigo',$artigo->id)->sum('quantidade');
            $totalStock = $tock + $artigo->qtd;
            return view('produtos.EntradaSaida',[
                'artigo'=>$artigo,
                'armagens'=>$armage,
                'tipoOper'=>$operation,
                'stock'=>$totalStock
            ]);
        } else {
            $artigo = DB::table('produtos')->where('id',$request->get('idArtigo'));
            if ($request->get('IdArmagen') =='') {
                // A verificar tipo de operation
                if ($request->get('tipoOper')=='Saida do stock') {
                    // A verificar se a quantidade para retirar e maior do que quantidade exixstente
                    if ($request->get('quantidade') <= $artigo->first()->qtd) {
                        $artigo->update([
                            'qtd'=>$artigo->first()->qtd - $request->get('quantidade'),
                        ]);
                        DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$request->get('idArtigo'),
                            'id_da_orden'=>'0',
                            'quantidade'=>$request->get('quantidade'),
                            'tipo_de_operacao'=>'Saida',
                            'idArmagen'=>'0',
                            'data'=>now(),
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno
                        ]);
                        // A selectionar os muvementos de compra deste produto
                        $compra = ProdutosComprado::where('idProd',$request->get('idArtigo'));
                        // A verificar se tem uma linha afetada nesta consulta
                        if ($compra->count() >0) {
                            db::table('produtos_comprados')->where('idProd',$request->get('idArtigo'))->update([
                                'quantidade'=>$compra->first()->quantidade + $request->get('quantidade')
                            ]);
                        } else {
                            $produtosComprado->idProd = $artigo->first()->id;
                            $produtosComprado->quantidade = $request->get('quantidade');
                            $produtosComprado->save();
                        }
                    } else {
                        echo '<div class="alert alert-danger">Atencão a quantidade para retirar não pode ser maior do que a quantidade real !!!</div>';
                    }
                } else {
                    $artigo->update([
                        'qtd'=>$artigo->first()->qtd + $request->get('quantidade'),
                    ]);
                    DB::table('muvementos_de_stock')->insert([
                        'id_responsavel'=>session('id_admin'),
                        'id_do_artigo'=>$request->get('idArtigo'),
                        'id_da_orden'=>'0',
                        'quantidade'=>$request->get('quantidade'),
                        'tipo_de_operacao'=>'Entrada',
                        'idArmagen'=>'0',
                        'data'=>now(),
                        'dia'=>$dia,
                        'mes'=>$mes,
                        'anno'=>$anno
                    ]);
                    // A selectionar os muvementos de compra deste produto
                    $compra = ProdutosComprado::where('idProd',$request->get('idArtigo'));
                    // A verificar se tem uma linha afetada nesta consulta
                    if ($compra->count() >0) {
                        db::table('produtos_comprados')->where('idProd',$request->get('idArtigo'))->update([
                            'quantidade'=>$compra->first()->quantidade + $request->get('quantidade')
                        ]);
                    } else {
                        $produtosComprado->idProd = $request->get('idArtigo');
                        $produtosComprado->quantidade = $request->get('quantidade');
                        $produtosComprado->save();
                    }
                }
            } else {
                // A selectionar stock deste artigo com este armagen na tabela stock
                $stock = DB::table('stocks')->where('IdArmagen',$armagen->id)->where('IdArtigo',$artigo->first()->id);
                // A verificar se existe uma linha afetada nesta consulta
                if ($stock->count()>0) {
                    // A verificar tipo de ioperation
                    if ($request->get('tipoOper')=='Saida do stock') {
                        // A verificar se a quantidade para retirar e maior do que quantidade exixstente
                        if ($request->get('quantidade') <= $stock->first()->quantidade) {
                            DB::table('stocks')->where('id',$stock->first()->id)->update([
                                'quantidade'=>$stock->first()->quantidade - $request->get('quantidade'),
                            ]);
                            DB::table('muvementos_de_stock')->insert([
                                'id_responsavel'=>session('id_admin'),
                                'id_do_artigo'=>$artigo->first()->id,
                                'id_da_orden'=>'0',
                                'quantidade'=>$request->get('quantidade'),
                                'tipo_de_operacao'=>'Saida',
                                'idArmagen'=>$armagen->id,
                                'data'=>now(),
                                'dia'=>$dia,
                                'mes'=>$mes,
                                'anno'=>$anno
                            ]);
                            // A selectionar os muvementos de compra deste produto
                        $compra = ProdutosComprado::where('idProd',$artigo->first()->id);
                        // A verificar se tem uma linha afetada nesta consulta
                        if ($compra->count() >0) {
                            db::table('produtos_comprados')->where('idProd',$request->get('idArtigo'))->update([
                                'quantidade'=>$compra->first()->quantidade - $request->get('quantidade')
                            ]);
                        } else {
                            $produtosComprado->idProd = $artigo->first()->id;
                            $produtosComprado->quantidade = $request->get('quantidade');
                            $produtosComprado->save();
                        }
                        } else {
                            echo '<div class="alert alert-danger">Atencão a quantidade para retirar não pode ser maior do que a quantidade real !!!</div>';
                        }
                    } else {
                        DB::table('stocks')->where('id',$stock->first()->id)->update([
                            'quantidade'=>$request->get('quantidade') + $stock->first()->quantidade,
                        ]);
                        DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$artigo->first()->id,
                            'id_da_orden'=>'0',
                            'quantidade'=>$request->get('quantidade'),
                            'tipo_de_operacao'=>'Entrada',
                            'idArmagen'=>$armagen->id,
                            'data'=>now(),
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno
                        ]);
                        // A selectionar os muvementos de compra deste produto
                        $compra = ProdutosComprado::where('idProd',$artigo->first()->id);
                        // A verificar se tem uma linha afetada nesta consulta
                        if ($compra->count() >0) {
                            db::table('produtos_comprados')->where('idProd',$request->get('idArtigo'))->update([
                                'quantidade'=>$compra->first()->quantidade + $request->get('quantidade')
                            ]);
                        } else {
                            $produtosComprado->idProd = $artigo->first()->id;
                            $produtosComprado->quantidade = $request->get('quantidade');
                            $produtosComprado->save();
                        }
                    }
                } else {
                    // A selectionar no stock
                    $stoc = DB::table('stocks')->where('IdArmagen',$armagen->id)->where('IdArtigo',$artigo->first()->id);
                    if ($request->get('tipoOper')=='Saida do stock') {
                        echo '<div class="alert alert-info">Atencão este artigo não tem registro neste armagens selectionado!!!</div>';
                    } else {
                        // A verificar tipo de ioperation
                        $stocks->IdArmagen = $armagen->id;
                        $stocks->IdArtigo = $artigo->first()->id;
                        $stocks->quantidade = $request->get('quantidade');
                        $stocks->save();
                        DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$artigo->first()->id,
                            'id_da_orden'=>'0',
                            'quantidade'=>$request->get('quantidade'),
                            'tipo_de_operacao'=>'Entrada',
                            'idArmagen'=>$armagen->id,
                            'data'=>now(),
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno
                        ]);
                        // A selectionar os muvementos de compra deste produto
                        $compra = ProdutosComprado::where('idProd',$artigo->first()->id);
                        // A verificar se tem uma linha afetada nesta consulta
                        if ($compra->count() >0) {
                            db::table('produtos_comprados')->where('idProd',$request->get('idArtigo'))->update([
                                'quantidade'=>$compra->first()->quantidade + $request->get('quantidade')
                            ]);
                        } else {
                            $produtosComprado->idProd = $artigo->first()->id;
                            $produtosComprado->quantidade = $request->get('quantidade');
                            $produtosComprado->save();
                        }
                    }
                }

            }

        }
    }
}
