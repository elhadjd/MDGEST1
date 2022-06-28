<?php

namespace App\Http\Controllers;

use App\Models\ArmagensModel;
use App\Models\caixas;
use App\Models\controloProdutosVendidos;
use App\Models\encomendasPos;
use App\Models\gastos;
use App\Models\lista_de_pedidos;
use App\Models\MarginProd;
use App\Models\produtos;
use App\Models\sessoes_caixas;
use App\Models\tb_usuariolog;
use CrestApps\CodeGenerator\Support\Arr;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use Laravel\Ui\Presets\React;

class PontoController extends Controller
{
    //
    public function ponto_de_venda()
    {
        // $produto = DB::table('lista_de_pedidos')->where('dia',date('d'))->get();
        // foreach ($produto as $value) {
        //     $cust = $value->quantidade * $value->preco_custo;
        //     DB::table('lista_de_pedidos')->where('id',$value->id)->update([
        //         'TotalCusto'=>$cust,
        //     ]);
        // }
        DB::table('caixas')->where('nome',null)->delete();
        if (!session('logado')) {
            return view('login.index');
        }else{
            $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('ponto_de_venda.ponto_de_venda',[
                'users'=>DB::table('tb_usuariolog')->where('id',"!=",session('id_admin'))->get(),
                'user'=>$user,
                'app'=>$app
            ]);
        }
    }
    // A trazer menu de ponto de venda
    public function menu_ponto_de_venda(caixas $caixa)
    {
        DB::table('caixas')->where('nome',null)->delete();
        return view('ponto_de_venda.manu_ponto_de_venda',[
            'caixa'=>$caixa->all()
        ]);
    }
    public function bloco_caixa(Request $request, caixas $caixa)
    {
        // A verificar se o usuario tem esta accesso==================================================
        // A selectionar usuario conectado
        $userAdmin = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        // A fazer a verificaçao
        if (str_replace(' ','',$userAdmin->nivel) !="Administrador") {
            // A qui o usuario nao tem accesso
            echo '<div class="alert alert-danger text-center h5">Usuario sem accesso !!!</div>';
        }else{
            // A qui o usuario tem accesso========================================
            // A verificar se existe id da caixa na url
            if ($request->get('id_caixa')) {
                $caixa = DB::table('caixas')->where('id',$request->get('id_caixa'))->first();
            }else{
                $data = date('Y-m-d H:m:i');
                $caixa->id_admin = $request->get('IdAdmin');
                $caixa->created_at = $data;
                $caixa->save();
                $caixa = DB::table('caixas')->where('id',$caixa->id)->first();
            }
            $usuarios = DB::table('tb_usuariolog')->orderBy('apelido','asc')->get();
            return view('ponto_de_venda.FormCaixa',[
                'IdCaixa'=>$caixa,
                'Armagens'=>ArmagensModel::all(),
                'list_user'=>$usuarios,
            ]);
        }
    }

    public function BlocoCaixa(Request $request , caixas $caixa)
    {
        // A atualizar tabela caixa

        $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        if (str_replace(' ','',$user->nivel) != 'Administrador') {
            return false;
        }
        else
        {
            // A verificar o tipo de assunto mandado
            if ($request->get('coluna') == 'id_user_relation') {
                // A selectionar a caixa por id de usuario recebido
                $caixa = DB::table('caixas')->where('id_user_relation',$request->get('asunto'))->count();
                // A verificar se este usuario selectionado esta relacionado a uma caixa
                if ($caixa > 0) {
                    echo '<div class="alert alert-danger text-center h5">Atenção este usuario ja tem uma <strong>caixa</strong> criada !!!</div>';
                }else{
                   $updat = DB::table($request->get('tabela'))->where('id',$request->get('idCaixa'))->update([
                        $request->get('coluna')=>$request->get('asunto')
                    ]);
                }
            } elseif ($request->get('coluna') == 'impresao') {
                $updat = DB::table($request->get('tabela'))->where('id',$request->get('idCaixa'))->update([
                    $request->get('coluna')=>$request->get('asunto')
                ]);
            }elseif ($request->get('coluna') == 'impresaoCliente') {
                $updat = DB::table($request->get('tabela'))->where('id',$request->get('idCaixa'))->update([
                    $request->get('coluna')=>$request->get('asunto')
                ]);
            }else{
                $updat = DB::table($request->get('tabela'))->where('id',$request->get('idCaixa'))->update([
                    $request->get('coluna')=>$request->get('asunto')
                ]);
            }
        }
    }

    public function FormularioSession(Request $request , sessoes_caixas $sessions , caixas $caixas)
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
        // A selectionar a caixa pelo id recebido
        $caixa = $caixas->where('id',$request->get('id_caixa'))->first();
        $caixa->estado = 'A abrir';
        $caixa->update();
        // A selectiona a session pelo id recebido
        $session = $sessions
        ->where('id_da_caixa',$request->get('id_caixa'))
        ->where('estado','!=','Fechado');
        // A veirificar se existe uma linha afetada
        if ($session->count() > 0) {
            // A qui existe uma linha afetada no banco de dados
            if ($session->first()->estado == 'Aberto') {
                $IdSession = $session->first()->id;
            } else {
                $IdSession = $session->first()->id;
            }
        }else {
            // A qui nao existe nemhuma linha afetada no banco de dados
            // a fazer insert
            $sessions->id_da_caixa = $caixa->id;
            $sessions->id_user_responsavel = session('id_admin');
            $sessions->estado = $caixa->estado;
            $sessions->dia = $dia;
            $sessions->mes = $mes;
            $sessions->ano = $anno;
            $sessions->save();
            $IdSession = $sessions->id;
        }
        // A selectionar a sessao pelo id
        $sesion = $sessions->where('id',$IdSession)->first();
        // A fazere return no view
        return view('ponto_de_venda.FormSeçoes',[
            'session'=>$sesion,
        ]);
    }
    // A selectionar a lista de sessoes
    public function SessoesCaixa(Request $request , sessoes_caixas $session)
    {
        if ($request->get('id_caixa') !='') {
            $sessoes = $session->where('id_da_caixa',$request->get('id_caixa'))->orderBy('id','DESC')->get();
            // A returnar par view
            return view('ponto_de_venda.sessoes',[
                'sessoes'=>$sessoes
            ]);
        }else{
            return false;
        }

    }
    public function SessoesCaixas(Request $request, sessoes_caixas $sesions)
    {

        // A selectionar a session da caixa
        $session = $sesions->where('id',$request->get('idSession'))->first();
        // A selectionar as encomendas desta session
        $encomendas = DB::table('encomendas_pos')->where('id_session',$session->id)->where('estado','Pago');
        // A selectionar os pagamentos no banco
        $terminal = DB::table('pagamentos_pos')->where('id_session',$request->get('idSession'));
        // A somar valor multicaixa
        $multicaixa = $terminal->sum('multicaixa');
        // A somar valor trasferencia
        $transferencia = $terminal->sum('trasferencia');
        // A somar total das vendas
        $total = $encomendas->sum('total');
        //A juntar vendas e abertura de caixa numerario
        $totaes = $session->saldo_de_abertura + $total;
        $totale = $totaes - $multicaixa - $transferencia;
        // A selectionar pedidos das encomendas
        $pedidos = DB::table('lista_de_pedidos')->where('id_session',$session->id);
        // A somar total em valor dos pedidos
        $totalValor = $pedidos->sum('total');
        // A calcular valor enformado e diferencia
        $valorDiferencia = $session->total_geral_informado - $totaes;
        return view('ponto_de_venda.FormSeçoes',[
            'session'=>$session,
            'transaçoes'=>$total,
            'total'=>$totale,
            'totalGeral'=>$totaes,
            'pedidos'=>$totalValor,
            'multicaixa'=> $multicaixa,
            'transferencia'=>$transferencia,
            'valorEnformado'=>$session->total_geral_informado,
            'diferencia'=>$valorDiferencia
        ]);

    }

    // A abrir controlo da caixa
    public function AbrirControloCaixa(Request $request , sessoes_caixas $sessions , caixas $caixas)
    {
        $session = $sessions->where('id',$request->get('idSession'))->first();
        $caixa = $caixas->where('id',$session->id_da_caixa)->first();
        // A inserir no banco
        $caixa->estado = 'Aberto';
        $caixa->update();
        // A abrir controlo da sesao
        $session->saldo_de_abertura = str_replace(' ','',$request->get('abertura'));
        $session->estado = 'Aberto';
        $session->update();
    }

    // A criar sessions
    public function HeaderPos(Request $request , sessoes_caixas $sessions)
    {

        // A selectiona a session pelo id recebido
        $session = $sessions
        ->where('id_da_caixa',$request->get('id_caixa'))
        ->where('estado','!=','Fechado');
        if ($session->count() == 1) {
            session(['id_session'=>$session->first()->id]);
            session(['id_caixa'=>$session->first()->id_da_caixa]);
        } elseif($session->count() > 1) {
            $sessions
        ->where('id_da_caixa',$request->get('id_caixa'))
        ->where('estado','!=','Fechado')
        ->delete();
        DB::table('caixas')->where('id',$request->get('id_caixa'))->update([
            'estado'=>'Fechado',
        ]);
        }else{
        }

    }


    // A encerrar o controlo da session
    public function FecharSession(Request $request , sessoes_caixas $sessionCaixas)
    {
        // A selectinar as encomendas
        $encomendas = DB::table('encomendas_pos')->where('id_session',$request->get('idSession'));
        // A verificar se nao existe nemhuma encomenda em progresso
        DB::table('lista_de_pedidos')->where('id_session',$request->get('idSession'))->where('estado','Cotaçao')->delete();
        foreach ($encomendas->get() as $value) {
            $PedidosPregress = DB::table('lista_de_pedidos')->where('id_encomenda',$value->id)->sum('total');
            DB::table('encomendas_pos')->where('id',$value->id)->update([
                'total'=>$PedidosPregress,
            ]);
        }
        // $numeroEncomenda = $PedidosPregress->first();
        // $progress = $PedidosPregress->count();
        // if ($progress > 0) {
        //     echo '<div class="alert alert-info">Atenção este sessão tem encomenda(s) nao enserrada(s) <strong>Nº '.$numeroEncomenda->id_encomenda.' </strong> Por favor verifica e tenta novamente !!!</div>';
        // } else {
        //A s encomenda
        $ValoEncomendas = $encomendas->sum('total');
        // A selectinar os pedidos
        $ValorPedidos = DB::table('lista_de_pedidos')->where('id_session',$request->get('idSession'))->sum('total');
        // A verificar se tem uma diferencia entre os valores
        $DiferenciaErro = $ValoEncomendas - $ValorPedidos;
        // se existir uma diferencia
        if ($DiferenciaErro !=0) {
            DB::table('sessoes_caixas')->where('id',$request->get('idSession'))->update([
                'diferenciaErro'=>$DiferenciaErro
            ]);
        }
        // A selectionar  session pelo id recebido
        $session = DB::table('sessoes_caixas')->where('id',$request->get('idSession'))->first();
        // A calcular a diferencia dos valores
        $diferencia = $request->get('valorEnformado') - $ValorPedidos;
        // A incerrar esta session
        DB::table('caixas')->where('id',$session->id_da_caixa)->update([
            'estado'=>'Fechado',
        ]);
        $sessionCaixass = $sessionCaixas::find($request->get('idSession'));
        $sessionCaixass->ValorEncomendas = $ValoEncomendas;
        $sessionCaixass->total_geral = $ValorPedidos + $session->saldo_de_abertura;
        $sessionCaixass->total_geral_informado = $request->get('valorEnformado');
        $sessionCaixass->estado = 'Fechado';
        $sessionCaixass->totalEncomendas = $encomendas->count();
        $sessionCaixass->update();
        echo '<div class="alert alert-success">Sessão encerrada com success !!!</div>';


    }
    //A trabalhar para relatorios
    public function Relatorios(Request $request, controloProdutosVendidos $controloProdutosVendidos, MarginProd $margin)
    {
        // A verificar a linha que foi clicada
        $linha = $request->get('tipo');
        if ($linha == 'Orden de venda') {
            return view('ponto_de_venda.orden_de_vendas',[
                'caixas'=>caixas::all(),
            ]);
        }
        elseif($linha == 'Relatorio'){
            return view('ponto_de_venda.RelatorioDiario');
        }
        elseif($linha == 'Gastos'){
            return view('ponto_de_venda.Gastos');
        }
        elseif($linha == 'Avaliaçao de stock'){
            // A selectionar todos os produtos
            $produtos = DB::table('produtos');
           $listProd = $produtos->paginate(1500);
           // A trazer todos produtos
           $produtoCalculo = $produtos->get();
           $totalCustos = 0;
           $TotalVendas = 0;
           foreach ($produtoCalculo as $produto) {
               // A calcular os produtos

            $totalCusto = $produto->qtd * $produto->preçocust;
            $totalCustos += $totalCusto;
            $TotalVenda = $produto->qtd * $produto->preçovenda;
            $TotalVendas += $TotalVenda;
           }
           $lucro = $TotalVendas - $totalCustos;
            return view('ponto_de_venda.AveliaçaoStock',[
                'produtos'=>$listProd,
                'Costos'=>$totalCustos,
                'vanda'=>$TotalVendas,
                'lucro'=>$lucro,
            ]);
        }

    }
    public function BuscarOrden(Request $request ,encomendasPos $encomendas)
    {
        if ($request->get('coluna')) {
            $encomendass = DB::table($request->get('table'))->where($request->get('coluna'),$request->get('tipo'))->limit(10)->orderBy('id','DESC')->get();
        } else {
            $IdOrden = $request->get('IdOrden');
        // a verificar se exist alguma letra
        if ($IdOrden !='') {
            $encomendass = DB::table('encomendas_pos')->where('id','LIKE','%'.$IdOrden.'%')->limit(20)->orderBy('id','DESC')->get();
        } else {
            $encomendass = $encomendas::orderBy('id',"desc")->paginate(50);
        }
        }
        return view('pesquisas',[
            'encomendas'=>$encomendass,
        ]);
    }
    public function ListPedido(Request $request , lista_de_pedidos $pedidoss , encomendasPos $encomendas)
    {
        // a selectionar a encomenda
        $encomenda = $encomendas::find($request->get('id_orden'));
        // A selectianar o pagamento da encomenda
        $pagamento = DB::table('pagamentos_pos')->where('id_encomenda',$request->get('id_orden'))->first();
        /// A calcular o pagamento desta encomenda
        $totalPago = $pagamento->numerario + $pagamento->multicaixa + $pagamento->trasferencia;
        // A selectionar a lista de pedidos desta encomenda
        $pedidos = $pedidoss->where('id_encomenda',$request->get('id_orden'))->get();
        // A calcolar margin desta encomenda
        $margin = 0;
        foreach ($pedidos as $key => $pedido) {
            # code...

            $totalCusto = $pedido['preco_custo'] * $pedido['quantidade'];
            $TotalVenda = $pedido['preco_venda'] * $pedido['quantidade'];
            $margins = $TotalVenda - $totalCusto;
            $margin += $margins;
        }
        return view('ponto_de_venda.ListPedidosOrden',[
            'pedidos'=>$pedidos,
            'encomendas'=>$encomenda,
            'totalPago'=>$totalPago,
            'pagamento'=>$pagamento,
            'margin'=>$margin,
        ]);
    }

    // a annular esta orden
    public function AnnularOrdenden(Request $request)
    {
        $IiEncomenda = $request->get('id_encomenda');
        // A selectionar a encomenda
        $encomenda = DB::table('encomendas_pos')->where('id',$IiEncomenda)->first();
        // A selectiobna a lista de pedido
        $lista = DB::table('lista_de_pedidos')->where('id_encomenda',$IiEncomenda)->get();
        foreach ($lista as  $pedidos) {
            // A selectionar os produtos correspondente
            $produtos = DB::table('produtos')->where('id',$pedidos->id_artigo)->first();
            // a calcular as quantidade
            $quantidade = $pedidos->quantidade + $produtos->qtd;
            // A voltar as quantidades
            DB::table('produtos')->where('id',$pedidos->id_artigo)->update([
                'qtd'=>$quantidade,
            ]);
            // a annular
            DB::table('lista_de_pedidos')->insert([
                'quantidade'=>'-'.$pedidos->quantidade,
                'preco_venda'=>'-'.$pedidos->preco_venda,
                'preco_custo'=>'-'.$pedidos->preco_custo,
                'total'=>'-'.$pedidos->total,
                'TotalCusto'=>'-'.$pedidos->TotalCusto,
                'estado'=>'Annulado',
                'id_encomenda'=>$pedidos->id_encomenda,
                'id_artigo'=>$pedidos->id_artigo,
                'pos_ativo'=>$pedidos->pos_ativo,
                'id_caixa'=>$pedidos->id_caixa,
                'id_responsavel'=>$pedidos->id_responsavel,
                'id_session'=>$pedidos->id_session,
                'desconto'=>$pedidos->desconto,
                'ano'=>$pedidos->ano,
                'mes'=>$pedidos->mes,
                'dia'=>$pedidos->dia,
            ]);
        }
        // a annular a encomenda
        DB::table('encomendas_pos')->where('id',$IiEncomenda)->update([
            'total'=>0,
            'estado'=>'Annulado',

        ]);
        // A annular pagamento
        $pagamento = DB::table('pagamentos_pos')->where('id_encomenda',$IiEncomenda)->first();
        DB::table('pagamentos_pos')->where('id_encomenda',$IiEncomenda)->update([
            'numerario'=>0,
            'multicaixa'=>0,
            'trasferencia'=>0,
            'valorPago'=>0,
            'troco'=>0,
        ]);
    }
    public function BuscarRelatorio(Request $request)
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
        if (!$request->get('data')) {
            $encomendas = DB::table('encomendas_pos')
            ->where('dia',$dia)
            ->where('mes',$mes)
            ->where('ano',$anno);
            // A levar total de vendas diaria
            $totalVendasDia = $encomendas->sum('total');
            // A selectionar a lista de pedidos
            $pedidos = DB::table('lista_de_pedidos')
            ->where('dia',$dia)
            ->where('mes',$mes)
            ->where('ano',$anno);
            $totalCosto = $pedidos->sum('TotalCusto');
            // A somar os gastos
            $gastos = DB::table('gastos')
            ->where('dia',$dia)
            ->where('mes',$mes)
            ->where('ano',$anno)->sum('valor');

            // A calcular lucro
            $lucros = $totalVendasDia - $totalCosto - $gastos;

            // A trazer tudos
            if ($request->get('lista')) {
                // Averificar se existe uma letra no input
                if ($request->get('lista')!='lista') {
                    $lista = DB::table('encomendas_pos')
                    ->where('id','LIKE','%'.$request
                    ->get('lista').'%')->limit(10)->get();
                }else{
                    $lista = $encomendas->limit(50)->orderBy('id',"DESC")->get();
                }
                // A trazer a lista das encomenda
                foreach ($lista as $liste) {
                    // A selectionar os artigos correspondente
                    $caixa = DB::table('caixas')->where('id',$liste->id_caixa)->first();
                    $funcionario = DB::table('tb_usuariolog')->where('id',$liste->id_responsavel)->first();
                    $mostrar[] = array('id'=>$liste->id,
                    'caixa'=>$caixa->nome,
                    'session'=>"Sessão".$liste->id_session,
                    'funcionario'=>$funcionario->apelido,
                    'total'=>number_format($liste->total,2,",",".")."Kz",
                    'estado'=>$liste->estado
                );

                }
                echo json_encode($mostrar);
            } else {
                $array = array('TotalDiario'=>number_format($totalVendasDia,2,",",".")."Kz",'Gastos'=>number_format($gastos,2,",",".")."Kz",'TotalLucro'=>number_format($lucros,2,",",".")."Kz");
                echo json_encode($array);
            }

        }
    }
    // a trazer todos os artigo para a tabela avaliation de stock
    public function ArtigosAvaliation(Request $request)
    {
        if ($request->get('coluna')) {
            $produtos = DB::table($request->get('table'))->where($request->get('coluna'),$request->get('tipo'))->limit(10)->orderBy('id','DESC')->get();
        } else {
            $Idprod = $request->get('Idprod');
            // a verificar se exist alguma letra
            if ($Idprod !='') {
                $produtos = DB::table('produtos')->where('nome','LIKE','%'.$Idprod.'%')->limit(10)->orderBy('id','DESC')->get();
            } else {
                $produtos = produtos::orderBy('id',"desc")->paginate(1000);
            }
        }
        return view('pesquisas',[
            'produtosAvaliation'=>$produtos
        ]);
    }

    public function MuvementosProd(Request $request, controloProdutosVendidos $ControloVendasProd)
    {
        if ($request->get('table') != 'margin_prods') {
            // A selectionar os produtos consuante enformaçoes recebidos
            $vandidos = DB::table($request->get('table'))->orderBy($request->get('coluna'),$request->get('tipo'))->get();
            return view('ponto_de_venda.ControloDeVendasProdutos',[
                'resutado'=>$vandidos,
            ]);
            dd($vandidos);
        } else {
            $vandidos = DB::table($request->get('table'))->orderBy($request->get('coluna'),$request->get('tipo'))->get();
            return view('ponto_de_venda.ControloDeVendasProdutos',[
                'margin'=>$vandidos
            ]);
        }
    }
    // A adiciona um nopvo gasto no banco de dados
    public function AdicionarGasto(Request $request, gastos $gastos)
    {
        if ($request->get('assunto')) {
            DB::table('gastos')
            ->where('id',$request->get('IdGasto'))
            ->update([
                'assunto'=>$request->get('assunto'),
                'valor'=>$request->get('valor')
            ]);
        }elseif($request->get('lista')){
            // A verificar se a lista esta vazia
            if ($request->get('lista') != 'tudo') {
                $lista = DB::table('gastos')->where('dataPesquisa',"LIKE","%".$request->get('lista')."%")->limit(20)->orderBy('id',"DESC")->get();
                $totalGastos = DB::table('gastos')->where('dataPesquisa',"LIKE","%".$request->get('lista')."%")->sum('valor');

            }else{
                $totalGastos = DB::table('gastos')->sum('valor');
                $lista = DB::table('gastos')->limit(50)->orderBy('id',"DESC")->get();
            }
            return view('pesquisas',[
                'ListaGastos'=>$lista,
                'total'=>$totalGastos
            ]);
        }elseif($request->get('cancelar')){
            DB::table('gastos')->where('id',$request->get('IdGasto'))->delete();
        }else{
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
            // A selectionar o usuario conectado
            $user = DB::table('tb_usuariolog')
            ->where('id',session('id_admin'))->first();
            // A ciar uma linha no banco
            $gastos->idUser = $user->id;
            $gastos->dia = $dia;
            $gastos->mes = $mes;
            $gastos->ano = $anno;
            $gastos->dataPesquisa = $dia."-".date('m')."-".$anno;
            $gastos->save();

            $array = array('idGasto'=>$gastos->id, 'Responsavel'=>$user->apelido);
            echo json_encode($array);
        }
    }
    public function testandoForm(Request $request, MarginProd $marginProds)
    {
        $produto = DB::table('produtos')->where('id',$request['idProd'])->first();
        DB::table('margin_prods')->where('id_prod',$produto->id)->update([
            'PrecoCusto'=>$produto->preçocust,
            'PrecoVenda'=>$produto->preçovenda,
            'margin'=>$produto->preçovenda - $produto->preçocust
        ]);
        $request->validate([
            'imagem'=>'required',
        ]);
        if ($request->hasFile('imagem')) {
            //  A validar a extensão do arquivo
           $input = $request->validate([
                'imagem'=> 'mimes:png,jpg,bmp,jif,jpg,jpeg,'
            ]);
            $caminho = $input['imagem']->store('produtos','public');
            DB::table('produtos')->where('id',$request['idProd'])->update([
                'imagem'=>str_replace('produtos/','',$caminho),
            ]);
        } else {
            # code...
        }

    }
}
