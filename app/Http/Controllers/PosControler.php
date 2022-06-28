<?php

namespace App\Http\Controllers;

use App\Models\BatePaposModel;
use App\Models\ClientePos;
use App\Models\controloProdutosVendidos;
use App\Models\encomendasPos;
use App\Models\FaturacaoModel;
use App\Models\lista_de_pedidos;
use App\Models\pagamentosPos;
use App\Models\PedidoFaturaModel;
use App\Models\sessoes_caixas;
use App\Models\tb_usuariolog;
use App\Models\TipoFaturaModel;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Div;

class PosControler extends Controller
{
    //
    public function pos(Request $request)
    {
        # code...
        if (!session('logado')) {
            return view('login.index');
        } elseif(session('id_session')=='') {
            $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('ponto_de_venda.ponto_de_venda',[
                'users'=>DB::table('tb_usuariolog')->where('id',"!=",session('id_admin'))->get(),
                'user'=>$user,
                'app'=>$app
            ]);
        }elseif(session('id_caixa')==''){
            $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('ponto_de_venda.ponto_de_venda',[
                'users'=>DB::table('tb_usuariolog')->where('id',"!=",session('id_admin'))->get(),
                'user'=>$user,
                'app'=>$app
            ]);
        }else {
            $session = DB::table('sessoes_caixas')->where('id',session('id_session'))->first();
            if ($session->id_user_responsavel != session('id_admin')) {
                $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('ponto_de_venda.ponto_de_venda',[
                'user'=>$user,
                'app'=>$app,
                'menssagem'=>'<div class="alert alert-danger">Atenção este usuario não e permetido entrar nesta caixa pois não e que fez a abertura da sessão desta caixa !!!</div>',
            ]);
            } else {
                return view('pos.App',[
                    'lista'=>''
                ]);
            }
        }
    }
    public function menuPos()
    {
        $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        return view('pos.HomePos',[
            'usuario'=>$user,
            'users'=>DB::table('tb_usuariolog')->where('id',"!=",session('id_admin'))->get(),
        ]);
    }
    public function ListaArtigos(Request $request , produtos $produtos)
    {
        if ($request->get('pesquisar')!='') {
            $produto = DB::table('produtos')->where('nome','LIKE','%'.$request->get('pesquisar').'%')->orderBy('nome','ASC')->limit(15)->get();
        } else {
            $produto = DB::table('produtos')->where('nome','!=','')->orderBy('nome','ASC')->limit(20)->get();
        }
        return view('pos.ListaArtigos',[
            'artigos'=>$produto
        ]);

    }

    // A Sair do pos
    public function SairPos()
    {
        session(['id_session'=>'']);
        session(['id_caixa'=>'']);
    }

    // A trazer o formulario de pagamento
    public function FormPagamento(lista_de_pedidos $pedidos,sessoes_caixas $sessions , encomendasPos $encomendas)
    {
        // A selctionar a encomenda
        $encomenda = $encomendas
        ->where('id_session',session('id_session'))
        ->where('pos_ativo',session('pos'))
        ->where('id_caixa',session('id_caixa'))
        ->where('id_responsavel',session('id_admin'))
        ->where('estado','Cotaçao')
        ->first();
        // A selectionar a lista de pedidos
        $lista = $pedidos->where('id_encomenda',$encomenda->id)
        ->where('pos_ativo',session('pos'))
        ->where('estado','Cotaçao')
        ->where('id_responsavel',session('id_admin'))
        ->where('id_caixa',session('id_caixa'));
        //A verificar se existe produto para pagar
        if ($lista->count()>0) {
            $total = $lista->sum('total');
            $listeArtigo = $lista->get();
            $metohos = DB::table('methodo_de_pagamento')->get();
            // a retornar para visualizaçao
            return view('pos.pagamento',[
                'tipoFaturas'=>TipoFaturaModel::all(),
                'encomenda'=>$encomenda,
                'total'=>$total,
                'lista'=>$listeArtigo,
                'methodo'=>$metohos
            ]);
        } else {
            '<div class="alert alert-danger">Por favor adiciona um artigo para fazer pagamento !!!</div>';
            dd();
        }

    }

    // A valida pagamento pos
    public function ValidarPagamento(Request $request, controloProdutosVendidos $controloProd , pagamentosPos $pagamento,lista_de_pedidos $lista_de_pedidos, encomendasPos $encomendas)
    {

        // a selectionar a encomenda
        $encomenda = $encomendas->where('id',$request->get('idIncomenda'))->first();
        // A selectionar a lista de pedidos
        $lista = DB::table('lista_de_pedidos')->where('id_encomenda',$encomenda->id)
        ->where('pos_ativo',session('pos'))
        ->where('estado','Cotaçao')
        ->where('id_responsavel',session('id_admin'))
        ->where('id_caixa',session('id_caixa'));
        $total = $lista->sum('total');
        // A calcular valors pago
        $valor = $request->get('Numerario') + $request->get('Multicaixa') + $request->get('Transferencia');
        // A calcular troco do cliente
        $troco = $total - $valor;
        // A verificar se o valor e suficiente
        if ((str_replace(' ','',$request->get('TipoFatura'))=='Prontopagamento')&&($troco > 0)) {
            echo '<div class="alert alert-danger">Atensão valor isuficiente !!!</div>'.$valor."#".$encomenda->total;
            dd();
        } else {
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
            // selectionar a lista pelo id da encomenda
            $listas = DB::table('lista_de_pedidos')->where('id_encomenda',$encomenda->id);
            // A verificar se existe um artigo nesta encomenda
            if ($lista->count()>0) {
                 // A calcular o troco de cliente opara manter segurança no sistema
                $totalControlo = $listas->sum('total');
                $trocoControlo = $totalControlo - $valor;
                // A verificar se valor enformado e suficiente
                if ((str_replace(' ','',$request->get('TipoFatura'))=='Prontopagamento')&&($totalControlo > $valor)) {
                    echo '<div class="alert alert-danger">Erro nesta encomenda por favor tenta novamente !!!</div>';
                    dd();
                } elseif ($trocoControlo != $troco) {
                    echo '<div class="alert alert-danger">Erro nesta encomenda por 2 favor tenta novamente !!!</div>';
                    dd();
                } elseif ($encomenda->total != $totalControlo) {
                    echo '<div class="alert alert-danger">Erro nesta encomenda por favor tenta novamente !!!</div>';
                    dd();
                }else {
                    foreach ($listas->get() as $artigos) {
                        // A selectinar o artigo correspondente pelo id
                        $artigo = DB::table('produtos')->where('id',$artigos->id_artigo)->first();
                        // A calcular as quantidades
                        $quantidades = $artigo->qtd - $artigos->quantidade;
                        DB::table('produtos')->where('id',$artigos->id_artigo)
                        ->update([
                            'qtd' => $quantidades,
                        ]);
                        // A manda a quantidade na tabela controlo dos produtos vendidos
                        $controloPro = DB::table('controlo_produtos_vendidos')->where('idProd',$artigos->id_artigo)->first();
                        $quantidade = $controloPro->quantidade + $artigos->quantidade;
                        DB::table('controlo_produtos_vendidos')->where('id',$controloPro->id)->update([
                            'quantidade'=>$quantidade,
                        ]);
                        // A mendar muvemento de stock
                        DB::table('muvementos_de_stock')->insert([
                            'id_responsavel'=>session('id_admin'),
                            'id_do_artigo'=>$artigos->id_artigo,
                            'id_da_orden'=>$artigos->id_encomenda,
                            'idArmagen'=>$artigos->armagen,
                            'quantidade'=>$artigos->quantidade,
                            'tipo_de_operacao'=>'Saida Pos',
                            'dia'=>$dia,
                            'mes'=>$mes,
                            'anno'=>$anno,
                            'data'=>now()
                        ]);
                    }
                    if ($totalControlo<=$valor) {
                        $trocos = $troco;
                    } else {
                        $trocos = 0;
                    }
                    // A mendar os valores no banco de dados
                    $pagamento->id_session = session('id_session');
                    $pagamento->id_encomenda = $request->get('idIncomenda');
                    $pagamento->numerario = $request->get('Numerario');
                    $pagamento->multicaixa = $request->get('Multicaixa');
                    $pagamento->trasferencia = $request->get('Transferencia');
                    $pagamento->troco = $trocos;
                    $pagamento->valorPago = $valor;
                    $pagamento->save();
                    // A validar a encomenda
                    $encomenda->estado = 'Pago';
                    $encomenda->update();
                    // A valida a lista de pedido
                    $lista_de_pedido = DB::table('lista_de_pedidos')
                    ->where('id_encomenda',$encomenda->id)
                    ->update([
                        'estado'=>'Pago'
                    ]);
                }
            } else {
                echo '<div class="alert alert-danger">Erro nesta encomenda por favor tenta novamente !!!</div>';
                dd();
            }
        }
    }
    // A levar a fatuta para view
    public function BuscarFatura(Request $request, encomendasPos $encomendas ,PedidoFaturaModel $pedidoFaturaModel, FaturacaoModel $faturacaoModel)
    {
        // A verificar o tipo de dados recebido
        if ($request->get('idIncomenda')) {
            // A selectionar a encomenda correspondente
            $encomenda = DB::table('encomendas_pos')->where('id',$request->get('idIncomenda'));
            //A  verifiacar se existe cliente nesta fatura
            if ($encomenda->first()->cliente !='') {
                //A verificar se existe uma fatura com esta orrden desta encomenda
                $fatura  = DB::table('faturacao_models')->where('OrdenALT',$request->get('idIncomenda'));
                // A selectionar cliente correspondente a esta orden
                $cliente  = DB::table('cliente_pos')->where('nome',$encomenda->first()->cliente);
                //A verificar seeste cliente existe
                if ($cliente->count()>0) {
                    if ($fatura->count()>0) {
                        DB::table('pedido_fatura_models')->where('OrdenALT',$encomenda->first()->id)->delete();
                        // A selectionar lista de pedidos
                        $lista = DB::table('lista_de_pedidos')->where('id_encomenda',$encomenda->first()->id);
                        // A modificar o total da fatura
                        DB::table('faturacao_models')->where('OrdenALT',$encomenda->first()->id)->update([
                            'TotalFatura'=>$encomenda->first()->total,
                            'IdCliente'=>$cliente->first()->id,
                        ]);
                        // A verificar se existe linha afetada
                        if ($lista->count() >0) {
                            $listas = $lista->get();
                            foreach ($listas as $pedidos) {
                                // A mandar a lista de pedido na tabela
                                DB::table('pedido_fatura_models')->insert([
                                    'IdEncomenda' => $fatura->first()->id,
                                    'OrdenALT' => $fatura->first()->OrdenALT,
                                    'IdProd' => $pedidos->id_artigo,
                                    'quantidade' => $pedidos->quantidade,
                                    'PrecoCusto' => $pedidos->preco_custo,
                                    'PrecoVenda' =>$pedidos->preco_venda,
                                    'TotalVenda' => $pedidos->total,
                                    'TotalCusto' => $pedidos->TotalCusto,
                                    'Desconto' => $pedidos->desconto,
                                    'TotalDesconto' => $pedidos->total_desconto,
                                ]);
                            }
                            $menssagen[] = array('success'=>'Pronto pagamento');
                            echo json_encode($menssagen);
                        } else {
                            $menssagen[] = array('menssagen'=>'<div class="alert alert-danger">Atenção não existe artigo selectionado por favor verifique e tenta novamente !!!</div>');
                            echo json_encode($menssagen);
                        }
                    } else {
                        // A selectionar lista de pedidos
                        $lista = DB::table('lista_de_pedidos')->where('id_encomenda',$encomenda->first()->id);
                        // A verificar se existe linha afetada
                        if ($lista->count() >0) {
                            // A inserir uma fatura na tabela
                            $faturacaoModel->IdUser = session('id_admin');
                            $faturacaoModel->IdCliente = $cliente->first()->id;
                            $faturacaoModel->OrdenALT = $encomenda->first()->id;
                            $faturacaoModel->TotalFatura = $encomenda->first()->total;
                            $faturacaoModel->TipoFatura = '1';
                            $faturacaoModel->save();
                            $listas = $lista->get();
                            foreach ($listas as $pedidos) {
                                // A mandar a lista de pedido na tabela
                                DB::table('pedido_fatura_models')->insert([
                                    'IdEncomenda' => $faturacaoModel->id,
                                    'OrdenALT' => $faturacaoModel->OrdenALT,
                                    'IdProd' => $pedidos->id_artigo,
                                    'quantidade' => $pedidos->quantidade,
                                    'PrecoCusto' => $pedidos->preco_custo,
                                    'PrecoVenda' =>$pedidos->preco_venda,
                                    'TotalVenda' => $pedidos->total,
                                    'TotalCusto' => $pedidos->TotalCusto,
                                    'Desconto' => $pedidos->desconto,
                                    'TotalDesconto' => $pedidos->total_desconto,
                                ]);
                            }
                            $menssagen[] = array('success'=>'Pronto pagamento');
                            echo json_encode($menssagen);
                        } else {
                            $menssagen[] = array('menssagen'=>'<div class="alert alert-danger">Atenção não existe artigo selectionado por favor verifique e tenta novamente !!!</div>');
                            echo json_encode($menssagen);
                        }
                    }
                } else {
                    $menssagen[] = array('menssagen'=>'<div class="alert alert-danger">Atenção cliente não cadastrado por favor verifique e tenta novamente !!!</div>');
                    echo json_encode($menssagen);
                }
            } else {
                $menssagen[] = array('menssagen'=>'<div class="alert alert-info">Atenção não existe cliente nesta orden por favor adicione um cliente e tenta novamente !!!</div>');
                echo json_encode($menssagen);
            }
        } else {
            // A selectionar a fatura pelo id recebido
            $encomenda = DB::table('encomendas_pos')->where('id',$request->get('idEncomenda'))->first();
            // A selectionar os pagamentos desta encomenda
            $pagamento = DB::table('pagamentos_pos')->where('id_encomenda',$encomenda->id)->first();
            // A selectionar a lista de pedidos pelo id de encomenda selectionado
            $lista = DB::table('lista_de_pedidos')->where('id_encomenda',$encomenda->id);
            // A selectionar a caixa
            $caixa = DB::table('caixas')->where('id',session('id_caixa'))->first();
            // A receber a lista de pedidos
            $artigos = $lista->get();
            // A receber o total dos itens
            $itens = $lista->sum('quantidade');
            return view('pos.App',[
                'caixa'=>$caixa,
                'lista'=>$artigos,
                'total'=>$encomenda,
                'pagamento'=>$pagamento,
            ]);
        }
    }
    // A cliar um novo cliente
    public function NovoCliente(Request $request,ClientePos $clientePos , encomendasPos $encomenda)
    {
        // A verifiacr qual e o que vai se fazerrrr
        $cliente = $clientePos::find($request->get('id'));
        if ($request->get('dados')) {
            // A inserir id do novo cliente
            $clientePos->nome = '';
            $clientePos->save();
            echo $clientePos->id;
        } elseif($request->get('NomeCliente')) {
            $cliente->nome = $request->get('NomeCliente');
            $cliente->update();
            $encomendas = $encomenda::find(session('idEncomenda'));
            $encomendas->cliente = $request->get('NomeCliente');
            $encomendas->update();
            echo $encomendas->cliente;
        }elseif($request->get('nomeCliente')){
            $nome = $request->get('nomeCliente');
            $clentes = DB::table('cliente_pos')->where('nome','LIKE','%'.$nome.'%')->get();
            for ($i=0; $i <sizeof($clentes) ; $i++) {
                $clente = $clentes[$i];
                echo '
                <div class="resultadoNomeCliente">
                    <div>'.$clente->nome.'</div>
                </div>
                ';
            }
            ?>
            <script>
                $(".resultadoNomeCliente").click(function(){
                    var nomeClientePesq = $(this).text()
                    $.ajax({
                    type : "GET",
                    url : "/NovoCliente",
                    data : {nomeClientePesq : nomeClientePesq},
                    success : function(e){
                        $("#ResultadoClientes").hide();
                        $("#NomeCliente").val(e)
                    }
                })
                })
            </script>
            <?php
        }elseif($request->get('nomeClientePesq')){
            $encomendas = $encomenda::find(session('idEncomenda'));
            $encomendas->cliente = $request->get('nomeClientePesq');
            $encomendas->update();
            echo $encomendas->cliente;
        }

    }
    public function menssagens(Request $request,BatePaposModel $batePaposModel)
    {
        if (!session('logado')) {
            echo "Atencão a tua seção esta espirada por favor faça login para continuar";
        } else {
            if ($request->get('menssagen')) {
                $batePaposModel->IdUserPrincipal = $request->get('idPrincipal');
                $batePaposModel->IdUserDestino = $request->get('idEnvio');
                $batePaposModel->menssagen = $request->get('menssagen');
                $batePaposModel->estado = 'enviada';
                $batePaposModel->save();
            } elseif ($request->get('novas')) {
                $menssagens = DB::table('bate_papos_models')
                ->where('IdUserPrincipal',session('id_admin'))
                ->where('IdUserDestino',$request->get('IdUser'))
                ->orWhere('IdUserPrincipal',$request->get('IdUser'))
                ->where('IdUserDestino',session('id_admin'))
                ->orderBy('id',"ASC")->get();
                for ($i=0; $i <sizeof($menssagens) ; $i++) {
                    $message = $menssagens[$i];
                    ?>
                    <div <?php if ($message->IdUserPrincipal == session('id_admin')){ ?>
                            class="direita shadow"
                        <?php } ?>
                        class="shadow esquerda">
                        <div><?php echo $message->menssagen?></div>
                        <?php
                        if ($message->IdUserPrincipal == session('id_admin')) {
                            ?>
                                <div class="NaoLidaSms"><?php echo $message->estado?></div>
                                <div class="data"><?php echo (date('d-m-Y à\s H:i:s',strtotime($message->created_at)))?></div>
                            <?php
                        }?>
                    </div>
                    <?php
                    DB::table('bate_papos_models')
                    ->where('IdUserPrincipal',$request->get('IdUser'))
                    ->where('IdUserDestino',session('id_admin'))
                    ->where('estado','não lida')->update([
                        'estado'=>'visto',
                    ]);
                }
            }elseif ($request->get('BuscarUseresSms')) {
                $users = DB::table('tb_usuariolog')->where('id',"!=",session('id_admin'))->get();
                foreach ($users as $user){
                    $naolida = DB::table('bate_papos_models')
                    ->where('IdUserPrincipal',$user->id)
                    ->where('IdUserDestino',session('id_admin'))
                    ->where('estado','não lida')->count();
                    echo '
                    <div class="UsuariosBatePapos" IdUser="'.$user->id.'">
                        <img src="/csss/configuarcoes/img_user/'.$user->imagem.'" alt="">
                        <div class="NomeCompleto">'.$user->nome_completo.'</div>
                        <div class="NaoLida">'.$naolida.'</div>
                    </div>';
                }
                ?>
                <script>
                    $(".UsuariosBatePapos").click(function(){
                        var IdUser = $(this).attr("IdUser")
                        $.ajax({
                            type : "GET",
                            url : "/menssagens",
                            data : {
                                IdUser : IdUser,
                            },
                            beforeSend : function(){
                                $(".proccessar").show();
                            },
                            success : function(data){
                                $(".blocoUsuarios").html(data)
                                $(".proccessar").hide();
                            }
                        })
                    })
                </script>
                <?php
            } elseif ($request->get('NumerosSms')) {
                $naolida = DB::table('bate_papos_models')
                    ->where('IdUserDestino',session('id_admin'))
                    ->where('estado','não lida')->count();
                    echo $naolida;
            } elseif ($request->get('Alert')) {
                $naolida = DB::table('bate_papos_models')
                    ->where('IdUserDestino',session('id_admin'))
                    ->where('estado','enviada');
                    if ($naolida->count()>0) {
                        echo '<div class="alerte">'.$naolida->first()->menssagen.'</div>';
                        DB::table('bate_papos_models')
                        ->where('IdUserDestino',session('id_admin'))
                        ->where('estado','enviada')->update([
                            'estado'=>'não lida',
                        ]);
                    }
            }else{
                $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
                $destino = DB::table('tb_usuariolog')->where('id',$request->get('IdUser'))->first();
                // dd($menssagens);
                return view('pos.menssagens',[
                    'destino'=>$destino,
                    'user'=>$user,
                ]);
            }
        }
    }
}
