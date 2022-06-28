<?php
namespace App\Http\Controllers;

use App\Models\ArmagensModel;
use App\Models\fornecedores;
use App\Models\listcompra as ModelsListcompra;
use App\Models\ProdutosComprado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use SebastianBergmann\Exporter\Exporter;

class listcompra extends Controller
{
    //
    public function InserirOrdenDeCompra(Request $request)
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
        $data = date("d-M-Y H:i:s");
        // DB::create('id_responsavel',$request)->all();
       $id_orden_criado = DB::table('listcompra')->insertGetId([
            'id_responsavel'=>$_GET['id_responsavel'],
            'estado'=>'Cotaçao',
            'data'=>$data,
            'dia'=>$dia,
            'mes'=>$mes,
            'anno'=>$anno
        ]);
        if ($id_orden_criado) {
            DB::table('listcompra')->where('id',$id_orden_criado)->update([
                'id_fornecedor'=>1,
                'referencia'=>"Orden0".$id_orden_criado,
            ]);
            echo ($id_orden_criado);
        }
    }

    // A levar para o arquivo nova_orden_compra
    public function nova_orden_compra(Request $request)
    {
        // A selectionar orden de compra no banco
        $orden_clicados = DB::table('listcompra')->where('id',$_GET['id_principal_orden'])->first();
        // A verificar se existe fornecedor deste orden
        if (!empty($orden_clicados->id_fornecedor)) {
            // A selectionar fornecedor pilo id
            $fornecedo = DB::table('fornecedores')->where('id',$orden_clicados->id_fornecedor)->first();
            $fornecedor = $fornecedo->nome;
        }else{
            $fornecedor = '';
        }

        // A trazer total da encomenda
        $total = DB::table('novo_pedido_de_compra')->where('id_Orden',$_GET['id_principal_orden'])->sum('total');
        // A trazer total de desconto
        $desconto = dB::table('novo_pedido_de_compra')->where('id_Orden',$_GET['id_principal_orden'])->sum('total_desconto');
        //A trazer total de IVA
        $iva = DB::table('novo_pedido_de_compra')->where('id_Orden',$_GET['id_principal_orden'])->sum('total_iva');
        // A selctionar lista dos produtos pedido
        $lista_prod = DB::table('novo_pedido_de_compra')->where('id_Orden',$_GET['id_principal_orden'])->orderBy('id','ASC')->get();

        // A selectionar os pagamento da orden
        $pagamentos = DB::table('pagamentos_de_compras')->where('id_da_orden',$_GET['id_principal_orden'])->sum('valor_pago');
        $resto = $total - $pagamentos;
        session(['id' => $orden_clicados->id]);
        $total_sem_des = $total + $desconto - $iva;
        return view('compras.nova_orden_compra',
        [
            'estado'=>$orden_clicados->estado,
            'id_principal_orden'=>$orden_clicados->id,
            'nome_de_fornecedor'=>$fornecedor,
            'lista_prod_pedido'=>$lista_prod,
            'total_orden'=>$total,
            'idArmagen'=>$orden_clicados->IdArmagen,
            'total_desconto'=>$desconto,
            'armagens'=>ArmagensModel::all(),
            'total_iva'=>$iva,
            'total_sem_desconto'=>$total_sem_des,
            'valor_pago'=>$pagamentos,
            'valor_a_pagar'=>$resto
        ]);
    }

    // A pesquisar produtos
    public function pesquisar_produtos(Request $request)
    {
        $nome_artigo = $request->get('search_prod');
        $pesquisar = DB::table('produtos')->where('nome','LIKE','%'.$nome_artigo.'%')->get();
        return view('compras.nova_orden_compra',[
            'artigos'=>$pesquisar
        ]);

    }



    // A adicionar novos produtos para pedido docliente
    public function add_produtos_pedido(Request $request)
    {
        $condicao = DB::table('listcompra')->where('id',$request->get('id_orden'))->first();
        if (str_replace(' ','',$condicao->estado) =='Validado') {
            echo  '<div class="alert alert-danger">Atenção esta orden não pode ser editada por estar encerrada !!!</div>';
        }elseif (str_replace(' ','',$condicao->estado) == 'Confirmado') {
            echo '<div class="alert alert-info">Por favor clica no botão editar !!!</div>';
        }else{
            $insert = DB::table('novo_pedido_de_compra')->insertGetId([
                'id_Orden'=>$_GET['id_orden'],
            ]);
            if ($insert) {
                echo $insert;
            }
        }

    }



    public function buscar_fornecedor(){
        if (empty($_GET['pesquisar_frncd'])) {
            $fornecedor = DB::table('fornecedores')->get();
        return view('compras.nova_orden_compra',[
            'fornecer'=>$fornecedor,
        ]);
        }elseif(!empty($_GET['pesquisar_frncd'])){
            $fornecedor = DB::table('fornecedores')->where('nome','LIKE','%'.$_GET['pesquisar_frncd'].'%')->get();
        return view('compras.nova_orden_compra',[
            'fornecer'=>$fornecedor,
        ]);
        }
    }
    //  A enviar id de fornecedor no banco
    public function adicionar_fornecedor_na_orden(){
        $id = $_GET['id_do_fornecedor'];
        $value = session('id');
        $updat = DB::table('listcompra')->where('id',$value)->update(['id_fornecedor'=>$id]);
        if ($updat) {
            echo $value;
        }
    }

    // A selectionar todos orden de compra no banco
    public function orden_conpra(Request $request)
    {
        if (!session('logado')) {
            return view('login.index');
        }else{
            if ($request->get('IdArmagen')) {
                // A mandar id do armagen no banco de dados
                echo $request->get('idOrden');
                DB::table('listcompra')->where('id',$request->get('idOrden'))->update([
                    'IdArmagen'=>$request->get('IdArmagen')
                ]);
            } else {
                $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
                $list_artigos = DB::table('produtos')->paginate(10);
                $orden_venda = DB::table('listcompra')->orderBy('id','desc')->get();
                $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
                $total = DB::table('listcompra')->sum('total');
                return view('compras.comprahome',[
                    'user'=>$user,
                    'ordens_compra'=>$orden_venda,
                    'total'=>$total,
                    'list_compra'=>$list_artigos,
                    'app'=>$app
                ]);
            }
        }
    }
    // A trazer lista dos artigos
    public function lista_dos_artigos(Request $request)
    {
        $id_orden = $request->get('id_orden');
        $id_linha = $request->get('id_linha');
        if (empty($request->get('lista_artigos'))) {
            $list_artigos = DB::table('produtos')->limit('10')->get();
        }else{
            $list_artigos = DB::table('produtos')->where('nome','LIKE','%'.$request->get('lista_artigos').'%')->get();
        }
        if ($list_artigos->count()<=0) {
            return 'Nemhun artigo encontrador com este nome ('.$request->get('lista_artigos').')';
        }
        return view('compras.lista_artigos',[
            'id_orden'=>$id_orden,
            'id_linha'=>$id_linha,
            'produtos'=>$list_artigos
        ]);
    }


    // A adicionar produto na orden
    public function adicionar_artigo(Request $request)
    {
        $condicao = DB::table('listcompra')->where('id',$request->get('id_da_orden'))->first();
        if (str_replace(' ','',$condicao->estado) =='Validado') {
            echo  '<div class="alert-danger">Atenção esta orden não pode ser editada por estar encerrada !!!</div>';
        }elseif (str_replace(' ','',$condicao->estado) == 'Confirmado') {
            echo '<div class="alert alert-info">Por favor clica no botão editar !!!</div>';
        }else{
            $produto = DB::table('produtos')->where('id',$request->get('id_artigo'))->first();
            // A selectionar a encomenda
            $encomenda = DB::table('listcompra')->where('id',$request->get('id_da_orden'))->first();
            // A verificar se existe armagen nesta encomenda
            if ($encomenda->IdArmagen !='') {
                // A selectionar no stock
                $stock = DB::table('stocks')->where('IdArmagen',$encomenda->IdArmagen)->where('IdArtigo',$produto->id);
                // A verificar se tem uma linha afetada nesta consulta
                if ($stock->count() > 0) {
                    # code...
                } else {
                    DB::table('stocks')->insert([
                        'IdArmagen'=>$encomenda->IdArmagen,
                        'IdArtigo'=>$produto->id,
                        'quantidade'=>0,
                    ]);
                }

            }
            // A inserir o produto na encomenda
            $update = DB::table('novo_pedido_de_compra')->where('id',$request->get('id_da_linha'))->update([
                'id_produto'=>$produto->id,
                'custo'=>$produto->preçocust,
                'artigo'=>$produto->nome,
            ]);
        }
    }


    // A fazer update os muvementos
    public function updat_linha_de_pedido(Request $request)
    {
        $condicao = DB::table('listcompra')->where('id',$request->get('id_orden'))->first();
        if (str_replace(' ','',$condicao->estado) =='Validado') {
            echo  '<div class="alert alert-danger">Atenção esta orden não pode ser editada por estar encerrada !!!</div>';
        }elseif (str_replace(' ','',$condicao->estado) =='Confirmado') {
            echo '<div class="alert alert-info">Por favor clica no botão editar !!!</div>';
        }else{
            $update = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->update([
                $request->get('colun')=>$request->get('numero'),
            ]);
            $linha = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->first();
            if ($request->get('colun')=='desconto') {
                $desconto = $linha->custo / 100 * $linha->quantidade * $request->get('numero');
                $total = $linha->custo * $linha->quantidade - $desconto;
                $totale = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->update([
                    'total_desconto'=>$desconto,
                ]);
                $orden = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->first();
                $total_desconto = DB::table('novo_pedido_de_compra')->where('id_Orden',$orden->id_Orden)->sum('total_desconto');
                $total_orden = DB::table('novo_pedido_de_compra')->where('id_Orden',$orden->id_Orden)->sum('total');
                $preco_final = $total_orden / $linha->quantidade;
                $update_total = DB::table('listcompra')->where('id',$orden->id_Orden)->update([
                    'preco_final'=>$preco_final,
                    'total'=>$total_orden,
                    'total_desconto'=>$total_desconto
                ]);
            }elseif($request->get('colun')=='iva'){
                $total_fatura = $linha->quantidade * $linha->custo - $linha->total_desconto;
                $preco_unit = $total_fatura / $linha->quantidade ;
                $total_iva = $preco_unit / 100 * $request->get('numero') * $linha->quantidade;
                $total = $linha->custo * $linha->quantidade - $linha->total_desconto + $total_iva;
                $preco_final = $total / $linha->quantidade;
                $totale = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->update([
                    'total'=>$total,
                    'preco_final'=>$preco_final,
                    'total_iva'=>$total_iva
                ]);
                $orden = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->first();
                $total_de_iva = DB::table('novo_pedido_de_compra')->where('id_Orden',$orden->id_Orden)->sum('total_iva');
                $total_orden = DB::table('novo_pedido_de_compra')->where('id_Orden',$orden->id_Orden)->sum('total');
                $update_total = DB::table('listcompra')->where('id',$orden->id_Orden)->update([
                    'total'=>$total_orden,
                    'total_iva'=>$total_de_iva
                ]);
            }else{
                $total = $linha->custo * $linha->quantidade;
                $totale = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->update([
                    'total'=>$total,
                ]);
                $orden = DB::table($request->get('tabela'))->where('id',$request->get('id_da_linha'))->first();
                $total_orden = DB::table('novo_pedido_de_compra')->where('id_Orden',$orden->id_Orden)->sum('total');
                $update_total = DB::table('listcompra')->where('id',$orden->id_Orden)->update([
                    'total'=>$total_orden
                ]);
            }
        }
    }

    // A filtrar a pesquisa por estado e fornecedore
    public function lista_das_orden_pesquisas(Request $request)
    {
        if (isset($_GET['toda_lista'])) {
            $recebido = DB::table('listcompra')->limit(20)->orderBy('id',"DESC")->get();
            $total = Db::table('listcompra')->sum('total');
        }elseif ($request->get('pesquisar')) {
            $recebido = DB::table('listcompra')->where('id','LIKE','%'.$request->get('pesquisar').'%')->limit(3)->orderBy('id',"DESC")->get();
            $total = Db::table('listcompra')->where('id','LIKE','%'.$request->get('pesquisar').'%')->limit(3)->sum('total');
        }else{
            if ($request->get('coluna')=='total') {
                if ($request->get('tipo_por_psq')=="maior") {
                    $total = DB::table('listcompra')->where($request->get('coluna'),">",$request->get('valor'))->sum('total');
                    $recebido = DB::table('listcompra')->where($request->get('coluna'),">",$request->get('valor'))->orderBy('id','DESC')->get();
                }elseif ($request->get('tipo_por_psq')=="menor") {
                    $total = DB::table('listcompra')->where($request->get('coluna'),"<",$request->get('valor'))->limit(10)->sum('total');
                    $recebido = DB::table('listcompra')->where($request->get('coluna'),"<",$request->get('valor'))->limit(10)->orderBy('id','DESC')->get();
                }elseif ($request->get('tipo_por_psq')=="egual") {
                    $total = db::table('listcompra')->where($request->get('coluna'),"=",$request->get('valor'))->limit(10)->sum('total');
                    $recebido = DB::table('listcompra')->where($request->get('coluna'),"=",$request->get('valor'))->limit(10)->orderBy('id','DESC')->get();
                }
            }elseif ($request->get('coluna')=='dia') {
                $total = DB::table('listcompra')->where($request->get('coluna'),$request->get('por_dia'))->where($request->get('colun_mes'),$request->get('por_mes'))->limit(10)->sum('total');
                $recebido = DB::table('listcompra')->where($request->get('coluna'),$request->get('por_dia'))->where($request->get('colun_mes'),$request->get('por_mes'))->limit(10)->orderBy('id','DESC')->get();
            }elseif(($request->get('coluna')=='id_fornecedor') OR ($request->get('coluna')=='estado')){
                $total = DB::table('listcompra')->where($request->get('coluna'),$request->get('tipo_por_psq'))->limit(10)->sum('total');
                $recebido = DB::table('listcompra')->where($request->get('coluna'),$request->get('tipo_por_psq'))->limit(10)->orderBy('id','DESC')->get();
            }
        }

        if ($request->get('pagamentos')) {
           echo "esta fix";
        }else{
            return view('compras.lista_de_ordens',[
                'ordens_compra'=>$recebido,
                'total'=>$total,
            ]);
        }
    }

    // A apagare uma linha de pedido no banco
    public function apagar_linha_de_artigo_pedido(Request $request)
    {
        $delete = DB::table('novo_pedido_de_compra')->where('id',$request->get('id_da_linha_click'))->delete();
        $total = DB::table('novo_pedido_de_compra')->where('id_Orden',$request->get('id_orden'))->sum('total');
        $update = DB::table('listcompra')->where('id',$request->get('id_orden'))->update([
            'total'=>$total
        ]);
    }

    // clicar nos botoes de validaçoes
    public function validacaoes_de_orden(Request $request,ProdutosComprado $produtoscomprado)
    {
        if ($request->get('tipo_de_funçao') == 'Validado') {
            DB::table('novo_pedido_de_compra')->where('id_Orden',$request->get('id_orden'))->chunkById('*',function($linhas){
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
                $data = date("d-M-Y H:i:s");
                foreach ($linhas as  $linha) {
                    $produto = DB::table('produtos')->where('id',$linha->id_produto)->first();
                    // A selectionar esta encomenda
                    $encomenda = DB::table('listcompra')->where('id',$_GET['id_orden'])->first();
                    // A verificar se existe armagen nesta compra
                    if ($encomenda->IdArmagen !='') {
                        // A selectionart stock
                        $stock = DB::table('stocks')->where('IdArmagen',$encomenda->IdArmagen)->where('IdArtigo',$linha->id_produto)->first();
                        // A mandar a quntidade no stock corespondente a este armagen endicado
                        DB::table('stocks')->where('id',$stock->id)->update([
                            'quantidade'=>$stock->quantidade + $linha->quantidade,
                        ]);
                        $muvemento_stock = DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$produto->id,
                            'id_da_orden'=>$linha->id_Orden,
                            'quantidade'=>$linha->quantidade,
                            'tipo_de_operacao'=>'Entrada Por compra',
                            'idArmagen'=>$encomenda->IdArmagen,
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno,
                            'data'=>$data
                        ]);
                    }else{
                        $quantidade = $produto->qtd + $linha->quantidade;
                        $update = DB::table('produtos')->where('id',$linha->id_produto)->update([
                            'qtd'=>$quantidade,
                        ]);
                        $muvemento_stock = DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$produto->id,
                            'id_da_orden'=>$linha->id_Orden,
                            'quantidade'=>$linha->quantidade,
                            'tipo_de_operacao'=>'Entrada Por compra',
                            'idArmagen'=>'0',
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno,
                            'data'=>$data
                        ]);
                    }
                    $compras = DB::table('produtos_comprados')->where('idProd',$produto->id);
                    $compras->update([
                        'quantidade'=>$compras->first()->quantidade + $linha->quantidade,
                    ]);
                }
                $modifiq = DB::table('listcompra')->where('id',$_GET['id_orden'])->update([
                    'estado'=>$_GET['tipo_de_funçao'],
                ]);

            });
        }else{
            $valudacoes = DB::table('listcompra')->where('id',$request->get('id_orden'))->update([
                'estado'=>$request->get('tipo_de_funçao'),
            ]);
        }
    }
}
