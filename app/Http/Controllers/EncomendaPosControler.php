<?php

namespace App\Http\Controllers;

use App\Models\encomendasPos;
use App\Models\lista_de_pedidos;
use App\Models\produtos;
use App\Models\tb_usuariolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sail\Console\PublishCommand;
use phpDocumentor\Reflection\Types\This;

class EncomendaPosControler extends Controller
{
    //

    public function encomenda(PublishCommand $public, Request $request, encomendasPos $tabEncomenda,lista_de_pedidos $liata_de_pedido)
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
        // a criar uma sessão para pos
        $pos = $request->get('pos_ativo');
        if (!$pos) {
            if (!session('pos')) {
                session(['pos'=>"Pos1"]);
            }else{
            }
        }else{
            session(['pos'=>$pos]);
        }
        // A levar a encomenda
        $tab = DB::table('encomendas_pos')
        ->where('pos_ativo',session('pos'))
        ->where('id_responsavel',session('id_admin'))
        ->where('id_caixa',session('id_caixa'))
        ->where('id_session',session('id_session'))
        ->where('estado','Cotaçao');
        $verificar = $tab->count();
        if ($verificar > 0) {
            $id_linha = $tab->first();
            if ($id_linha->dia == $dia) {
            } else {
                DB::table('encomendas_pos')->where('id',$id_linha->id)->update([
                    'dia'=>$dia,
                    'mes'=>$mes,
                    'ano'=>$anno
                ]);
            }

            $EncomendaEncontrad = DB::table('encomendas_pos')->where('id',$id_linha->id)->first();
            $EncomendaEncontrada = $EncomendaEncontrad->id;
        }
        else
        {
            // A selectionar a caixa relationado
            $caixa = DB::table('caixas')->where('id',session('id_caixa'))->first();
            $tabEncomenda->pos_ativo = session('pos');
            $tabEncomenda->id_responsavel=session('id_admin');
            $tabEncomenda->id_caixa=session('id_caixa');
            $tabEncomenda->id_session=session('id_session');
            $tabEncomenda->estado='Cotaçao';
            $tabEncomenda->dia=$dia;
            $tabEncomenda->mes=$mes;
            $tabEncomenda->ano=$anno;
            $tabEncomenda->armagen = $caixa->Armagen;
            $tabEncomenda->save();
            $EncomendaEncontrada = $tabEncomenda->id;
        }
        session(['idEncomenda'=>$EncomendaEncontrada]);
        $total = DB::table('lista_de_pedidos')->where('id_encomenda',$EncomendaEncontrada)->sum('total');
        $lista_de_pedidos = DB::table('lista_de_pedidos')
        ->where('id_encomenda',$EncomendaEncontrada)
        ->orderBy("id",'ASC')
        ->get();
        return view('pos.encomendas',[
            'artigos'=>$lista_de_pedidos,
            'pos_ativo'=>session('pos'),
            'TotalEncomenda'=>$total,
            'NumEncomenda'=>session('idEncomenda')
        ]);
    }
    public function AddProd(Request $request , lista_de_pedidos $tabPedido,encomendasPos $TabEncomenda, produtos $produtos)
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
        // A selectionar o produto por id
        $produto = $produtos->all()
        ->where('id',$request->get('IdProd'))
        ->first();
        // A verificar se esta caixa tem um armagen relationado
        $caixa  = DB::table('caixas')->where('id',session('id_caixa'))->first();
        if ($caixa->Armagen !='') {
            // A selectionar a encomenda
            $encomenda = $TabEncomenda->all()
            ->where('id',session('idEncomenda'))
            ->first();
            // A verificar se existe ente artigo clicado na tabela
            $VerificarExisteIdArtigo = DB::table('lista_de_pedidos')
            ->where('id_artigo',$request->get('IdProd'))
            ->where('id_encomenda',$encomenda->id)
            ->where('pos_ativo',$encomenda->pos_ativo)
            ->where('id_caixa',$encomenda->id_caixa)
            ->where('id_responsavel',$encomenda->id_responsavel);
            // A selectionar stock correspondente a este armagen ralationado
            $stock = DB::table('stocks')->where('IdArmagen',$caixa->Armagen)->where('IdArtigo',$produto->id);
            // a verificar se este artigo pertense a este armagen
            if ($stock->count()>0) {
                $product = $tabPedido
                ->where('id_artigo',$request->get('IdProd'))
                ->where('estado','Cotaçao')
                ->where('armagen',$caixa->Armagen)
                ->sum('quantidade');
                //  A verificar se existe ente artigo clicado na tabela
                if ($VerificarExisteIdArtigo->count()>0) {
                    $encontrou = $VerificarExisteIdArtigo->first();
                    // A verificar se tem stock suficiente neste armagen relationado
                    // A verificar a quantidade
                    $quantidade = $product + $request->get('quantidade');
                    // A slectionar
                    if ($stock->first()->quantidade >= $quantidade) {


                        // A linha afetada
                        // A calcular total e a quantidade da linha encontrada
                        $quantidade = $encontrou->quantidade + $request->get('quantidade');
                        // A veririfiacr se o artigo clicado tem desconto
                        $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                        // A verificar se tem uma linha afetada
                        if ($listPrice->count() >0) {
                            // A verificar a quantidade encontrada
                            if ($listPrice->first()->quantidade <= $quantidade) {
                                $preco = $listPrice->first()->preco_de_desconto;
                                $total = $listPrice->first()->preco_de_desconto * $quantidade;
                            }else{
                                $preco = $produto->preçovenda;
                                $total = $produto->preçovenda * $quantidade;
                            }
                        } else {
                            $preco = $produto->preçovenda;
                            $total = $produto->preçovenda * $quantidade;
                        }
                        $TutalCusto = $produto->preçocust * $quantidade;
                        // A fazer update da luinha de pedido encontrado
                        $update = $tabPedido::find($encontrou->id);
                        $update->quantidade = $quantidade;
                        $update->preco_venda = $preco;
                        $update->total = $total;
                        $update->TotalCusto = $TutalCusto;
                        $update->update();
                        // A somar total desta encomenda
                        $totalEncomenda = $tabPedido->all()
                        ->where('id_encomenda',$encontrou->id_encomenda)
                        ->sum('total');
                        // A mendar total no banco
                        $updat = $TabEncomenda::find($encontrou->id_encomenda);

                        $updat->total = $totalEncomenda;
                        $updat->update();
                    }else{
                        echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente !!!</div>';
                    }
                }else{
                    // A verificar se tem stock suficiente neste armagen relationado
                    if ($stock->first()->quantidade >0) {
                            // A verificar a quantidade
                            $quantidade = $product + 1;
                            if ($produto->qtd >= $quantidade) {
                                $encomenda = $TabEncomenda::find(session('idEncomenda'));
                                // A inserir o produto no banco
                                $tabPedido->id_encomenda = $encomenda->id;
                                $tabPedido->id_artigo = $request->get('IdProd');
                                $tabPedido->pos_ativo = $encomenda->pos_ativo;
                                $tabPedido->id_caixa = $encomenda->id_caixa;
                                $tabPedido->id_responsavel = $encomenda->id_responsavel;
                                $tabPedido->preco_venda = $produto->preçovenda;
                                $tabPedido->armagen = $caixa->Armagen;
                                $tabPedido->preco_custo = $produto->preçocust;
                                $tabPedido->quantidade = $request->get('quantidade');
                                $tabPedido->total = $produto->preçovenda;
                                $tabPedido->dia = $dia;
                                $tabPedido->mes = $mes;
                                $tabPedido->ano = $anno;
                                $tabPedido->estado = 'Cotaçao';
                                $tabPedido->id_session = $encomenda->id_session;
                                $tabPedido->TotalCusto = $produto->preçocust;
                                $tabPedido->save();

                                $updat = $TabEncomenda::find(session('idEncomenda'));
                                // A trazer a lista de pedidos para inserir o total da encomenda
                                $lista = DB::table('lista_de_pedidos')->where('id_encomenda',session('idEncomenda'))->sum('total');
                                $updat->total = $lista;
                                $updat->update();
                            }else{
                                echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente !!!</div>';
                            }
                    } else {
                        echo '<div class="alert alert-danger">Atenção este artigo não tem stock suficiente neste armagen !!!</div>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger">Atenção este artigo não esta registrado neste armagen por favor adiciona e tenta novamente !!!</div>';
            }

        } else {
            // A qui nao tem armagen relationado===========================================================

            // A verificar os deste produto
            if ($produto->preçovenda < $produto->preçocust) {
                echo '<div class="alert alert-danger">Atenção o preço de venda não pode ser menor do que preço de custo !!!</div>';
            } else {

                // A selectionar a encomenda
                $encomenda = $TabEncomenda->all()
                ->where('id',session('idEncomenda'))
                ->first();

                // A verificar se existe ente artigo clicado na tabela
                $VerificarExisteIdArtigo = $tabPedido->all()
                ->where('id_artigo',$request->get('IdProd'))
                ->where('id_encomenda',$encomenda->id)
                ->where('pos_ativo',$encomenda->pos_ativo)
                ->where('id_caixa',$encomenda->id_caixa)
                ->where('id_responsavel',$encomenda->id_responsavel);
                $contar = $VerificarExisteIdArtigo->count();
                // A verificar
                if ($contar > 0) {
                    $encontrou = $VerificarExisteIdArtigo->first();

                    // A verificar se produto tem stock suficiente
                    // A selectionar produto pelo id recebido
                    $product = $tabPedido
                    ->where('id_artigo',$request->get('IdProd'))
                    ->where('estado','Cotaçao')
                    ->sum('quantidade');
                    // A verifiacr se o produtos esta detahado==========================================

                    $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$produto->id);
                    // A contar linhas
                    $linhas = $detalho->count();
                    // a fazer a verificaçao
                    if ($linhas >0 ) {
                        $encontrado = $detalho->first();
                        // A alterar a quantidade deste produto
                        DB::table('produtos')->where('id',$encontrado->idArtigodetalhado)->update([
                            'qtd'=>'0'
                        ]);
                        // A selectionar o artigo princiapl
                        $principal = DB::table('produtos')->where('id',$encontrado->idArtigoPrincipal)->first();
                        // a verificar a quantidade de artigo principal
                        $quantidade = $product + $request->get('quantidade');
                        // A calcular total e a quantidade da linha encontrada

                        // A multiplicar a quantidade principal na quantidade detalhado
                        $TotalQtdDetalho = $principal->qtd * $encontrado->Quantidade;
                        // a SOMAR A QUANTIDADE PARA MANDAR NO BANCO
                        $quant = $request->get('quantidade') + $encontrado->QuantidadeTemporaria;
                        //  A veridficar se tem stock suficient no artigo princial para detalho
                        if ($quant <= $TotalQtdDetalho) {
                            $quantidade = $encontrou->quantidade + $request->get('quantidade');
                            $total = $encontrou->preco_venda * $quantidade;
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= $quantidade) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = $listPrice->first()->preco_de_desconto * $quantidade;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = $produto->preçovenda * $quantidade;
                                }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = $produto->preçovenda * $quantidade;
                            }
                            $TutalCusto = $produto->preçocust * $quantidade;
                            // A fazer update da luinha de pedido encontrado
                            $update = $tabPedido::find($encontrou->id);
                            $update->quantidade = $quantidade;
                            $update->preco_venda = $preco;
                            $update->total = $total;
                            $update->TotalCusto = $TutalCusto;
                            $update->update();
                            // A somar total desta encomenda
                            $totalEncomenda = $tabPedido->all()
                            ->where('id_encomenda',$encontrou->id_encomenda)
                            ->sum('total');
                            // A mendar total no banco
                            $updat = $TabEncomenda::find($encontrou->id_encomenda);

                            $updat->total = $totalEncomenda;
                            $updat->update();
                            // A contar a quantidade em progresso
                            $contar = DB::table('artigos_detalhados')
                            ->where('idArtigodetalhado',$produto->id)
                            ->update([
                                'QuantidadeTemporaria' =>$quant
                            ]);
                            // A verificar se as quantidade do contolo estão egual

                            if (($quant >= $encontrado->Quantidade)) {

                                // A calcular o resto das quantidade
                                $resto = $quant - $encontrado->Quantidade;
                                // A inserir o resto da quantidade no banco de dados
                                $update = DB::table('artigos_detalhados')->where('id',$encontrado->id)->update([
                                    'QuantidadeTemporaria'=>$resto,
                                ]);
                                // A fazer update da da coluna quantidade na tabela produtos
                                DB::table('produtos')->where('id',$principal->id)->update([
                                    'qtd'=> $principal->qtd-1,
                                ]);
                                // A inseir o muvemento de stock no banco de dados
                                $muvemento = DB::table('muvementos_de_stock')->insert([
                                    'id_responsavel'=>session('id_admin'),
                                    'id_do_artigo'=>$principal->id,
                                    'id_da_orden'=>session('idEncomenda'),
                                    'quantidade'=>1,
                                    'tipo_de_operacao'=>'Saida Retalho',
                                    'dia'=>$dia,
                                    'mes'=>$mes,
                                    'anno'=>$anno,
                                    'data'=>now(),
                                ]);
                                // A selectionar o controlo das saidas e entradas
                                $controlo = DB::table('controlo_produtos_vendidos')
                                ->where('idProd',$principal->id);
                                $controlo->update([
                                    'quantidade'=>$controlo->first()->quantidade + 1,
                                ]);
                            }
                        } else {
                            echo '<div class="alert alert-danger">Atenção do artigo principal <strong>'.$principal->nome.'</strong> não tem stock suficiente !!!</div>';
                        }
                    }else{
                        // A verificar a quantidade
                        $quantidade = $product + $request->get('quantidade');
                        // A slectionar
                        if ($produto->qtd >= $quantidade) {


                            // A linha afetada
                            // A calcular total e a quantidade da linha encontrada
                            $quantidade = $encontrou->quantidade + $request->get('quantidade');
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= $quantidade) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = $listPrice->first()->preco_de_desconto * $quantidade;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = $produto->preçovenda * $quantidade;
                                }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = $produto->preçovenda * $quantidade;
                            }
                            $TutalCusto = $produto->preçocust * $quantidade;
                            // A fazer update da luinha de pedido encontrado
                            $update = $tabPedido::find($encontrou->id);
                            $update->quantidade = $quantidade;
                            $update->preco_venda = $preco;
                            $update->total = $total;
                            $update->TotalCusto = $TutalCusto;
                            $update->update();
                            // A somar total desta encomenda
                            $totalEncomenda = $tabPedido->all()
                            ->where('id_encomenda',$encontrou->id_encomenda)
                            ->sum('total');
                            // A mendar total no banco
                            $updat = $TabEncomenda::find($encontrou->id_encomenda);

                            $updat->total = $totalEncomenda;
                            $updat->update();
                        }else{
                            echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente !!!</div>';
                        }
                    }
                } else {
                    // Nehuma linha afetada no banco de dados
                    // A verifiacr se o produtos esta detahado==========================================

                    $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$produto->id);
                    // A contar linhas
                    $linhas = $detalho->count();
                    // a fazer a verificaçao
                    if ($linhas >0 ) {
                        $encontrado = $detalho->first();
                        // A alterar a quantidade deste produto
                        DB::table('produtos')->where('id',$encontrado->idArtigodetalhado)->update([
                            'qtd'=>'0'
                        ]);
                        // A selectionar o artigo princiapl
                        $principal = DB::table('produtos')->where('id',$encontrado->idArtigoPrincipal)->first();
                        // a verificar a quantidade de artigo principal
                        if ($principal->qtd >0) {
                            $product = $tabPedido
                            ->where('id_artigo',$request->get('IdProd'))
                            ->where('estado','Cotaçao')
                            ->sum('quantidade');
                            // A verificar a quantidade
                            $quantidade = $product + 1;
                            $encomenda = $TabEncomenda::find(session('idEncomenda'));
                            // A inserir o produto no banco
                            $tabPedido->id_encomenda = $encomenda->id;
                            $tabPedido->id_artigo = $request->get('IdProd');
                            $tabPedido->pos_ativo = $encomenda->pos_ativo;
                            $tabPedido->id_caixa = $encomenda->id_caixa;
                            $tabPedido->id_responsavel = $encomenda->id_responsavel;
                            $tabPedido->preco_venda = $produto->preçovenda;
                            $tabPedido->preco_custo = $produto->preçocust;
                            $tabPedido->quantidade = $request->get('quantidade');
                            $tabPedido->total = $produto->preçovenda;
                            $tabPedido->dia = $dia;
                            $tabPedido->mes = $mes;
                            $tabPedido->ano = $anno;
                            $tabPedido->estado = 'Cotaçao';
                            $tabPedido->id_session = $encomenda->id_session;
                            $tabPedido->TotalCusto = $produto->preçocust;
                            $tabPedido->save();

                            $updat = $TabEncomenda::find(session('idEncomenda'));
                            // A trazer a lista de pedidos para inserir o total da encomenda
                            $lista = DB::table('lista_de_pedidos')->where('id_encomenda',session('idEncomenda'))->sum('total');
                            $updat->total = $lista;
                            $updat->update();
                            // A contar a quantidade em progresso
                            $contar = DB::table('artigos_detalhados')
                            ->where('idArtigodetalhado',$produto->id)
                            ->update([
                                'QuantidadeTemporaria' =>$quantidade + $encontrado->QuantidadeTemporaria
                            ]);
                        } else {
                            echo '<div class="alert alert-danger">Atenção a quatidade do artigo principal nao e suficiente !!!</div>';
                        }

                    } else {
                        // A selectionar id da encomenda
                        if ($produto->qtd > 0) {
                            $product = $tabPedido
                            ->where('id_artigo',$request->get('IdProd'))
                            ->where('estado','Cotaçao')
                            ->sum('quantidade');
                            // A verificar a quantidade
                            $quantidade = $product + 1;
                            if ($produto->qtd >= $quantidade) {
                                $encomenda = $TabEncomenda::find(session('idEncomenda'));
                                // A inserir o produto no banco
                                $tabPedido->id_encomenda = $encomenda->id;
                                $tabPedido->id_artigo = $request->get('IdProd');
                                $tabPedido->pos_ativo = $encomenda->pos_ativo;
                                $tabPedido->id_caixa = $encomenda->id_caixa;
                                $tabPedido->id_responsavel = $encomenda->id_responsavel;
                                $tabPedido->preco_venda = $produto->preçovenda;
                                $tabPedido->preco_custo = $produto->preçocust;
                                $tabPedido->quantidade = $request->get('quantidade');
                                $tabPedido->total = $produto->preçovenda;
                                $tabPedido->dia = $dia;
                                $tabPedido->mes = $mes;
                                $tabPedido->ano = $anno;
                                $tabPedido->estado = 'Cotaçao';
                                $tabPedido->id_session = $encomenda->id_session;
                                $tabPedido->TotalCusto = $produto->preçocust;
                                $tabPedido->save();

                                $updat = $TabEncomenda::find(session('idEncomenda'));
                                // A trazer a lista de pedidos para inserir o total da encomenda
                                $lista = DB::table('lista_de_pedidos')->where('id_encomenda',session('idEncomenda'))->sum('total');
                                $updat->total = $lista;
                                $updat->update();
                            }else{
                                echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente !!!</div>';
                            }
                        }else{
                            echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente !!!</div>';
                        }
                    }
                }
            }
        }
    }
    // A deletar uma linha de pidido
    public function ApagarLinhaPedido(Request $request , lista_de_pedidos $tabPedidos, encomendasPos $TabEncomenda)
    {
        if ($request->get('IdProd')!='') {
            // A selectinar o artigo corespondente
            $artigo = DB::table('produtos')->where('id',$request->get('IdProd'))->first();
            // a selectionar a linha de pedidos
            $linhaPedid = DB::table('lista_de_pedidos')->where('id',$request->get('IdProd'))->first();
            // A selectionar na tabelo artigos detalhados
            $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$linhaPedid->id_artigo);
            // A verificar se o resultados e maior do que zero
            if ($detalho->count() > 0) {
                $linhaPedido = $tabPedidos->where('id',$request->get('IdProd'))->first();
                $quantidadeVoltar = $detalho->first()->QuantidadeTemporaria - $linhaPedido->quantidade;
                // A calcular a quantidade para retornar
                if ($quantidadeVoltar<="-".$detalho->first()->Quantidade) {
                    $quantidadeVolta = $quantidadeVoltar + $detalho->first()->Quantidade;
                    DB::table('produtos')->where('id',$detalho->first()->idArtigoPrincipal)->update([
                        'qtd'=>$artigo->qtd + 1,
                    ]);
                } else {
                    $quantidadeVolta = $quantidadeVoltar;
                }

                DB::table('artigos_detalhados')->where('id',$detalho->first()->id)->update([
                    'QuantidadeTemporaria'=>$quantidadeVolta,
                ]);
            }
            $deletar = $tabPedidos->where('id',$request->get('IdProd'))->delete();
            // A somar total desta encomenda
            $totalEncomenda = $tabPedidos->all()
            ->where('id_encomenda',session('idEncomenda'))
            ->sum('total');
            // A mendar total no banco
            $updat = $TabEncomenda::find(session('idEncomenda'));

            $updat->total = $totalEncomenda;
            $updat->update();
        } else {
            $linha = $tabPedidos->all()->where('id_encomenda',session('idEncomenda'))->max('id');
            // a selectionar a linha de pedidos
            $linhaPedid = DB::table('lista_de_pedidos')->where('id',$linha)->first();
            // A selectionar na tabelo artigos detalhados
            $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$linhaPedid->id_artigo);
            // A verificar se o resultados e maior do que zero
            if ($detalho->count() > 0) {
                // A selectinar o artigo corespondente
                $artigo = DB::table('produtos')->where('id',$detalho->first()->idArtigoPrincipal)->first();
                $linhaPedido = $tabPedidos->where('id',$linha)->first();
                $quantidadeVoltar = $detalho->first()->QuantidadeTemporaria - $linhaPedido->quantidade;
                // A calcular a quantidade para retornar
                if ($quantidadeVoltar<="-".$detalho->first()->Quantidade) {
                    $quantidadeVolta = $quantidadeVoltar + $detalho->first()->Quantidade;
                    DB::table('produtos')->where('id',$detalho->first()->idArtigoPrincipal)->update([
                        'qtd'=>$artigo->qtd + 1,
                    ]);
                } else {
                    $quantidadeVolta = $quantidadeVoltar;
                }
                DB::table('artigos_detalhados')->where('id',$detalho->first()->id)->update([
                    'QuantidadeTemporaria'=>$quantidadeVolta,
                ]);
            }
            $deletar = $tabPedidos->where('id',$linha)->delete();
            // A somar total desta encomenda
            $totalEncomenda = $tabPedidos->all()
            ->where('id_encomenda',session('idEncomenda'))
            ->sum('total');
            // A mendar total no banco
            $updat = $TabEncomenda::find(session('idEncomenda'));

            $updat->total = $totalEncomenda;
            $updat->update();
        }

    }

    // A alterar quantidade preços e descontos
    public function AlterarLinhaPedido(Request $request , lista_de_pedidos $tabPedido ,encomendasPos $tabEncomenda)
    {
        // A verificar se for quantidade
        if ($request->get('TipoAçao') !='quantidade') {
            $user = DB::table('tb_usuariolog')->find(session('id_admin'));
            // A verificar se este usuario esta autorizado a fazer isto
            if (str_replace(' ','',$user->nivel)!='Administrador') {
                echo '<div class="alert alert-danger">Usuario não autorizado !!!</div>';
            } else {
                if ($request->get('TipoAçao') == 'preco_venda') {
                    if ($request->get('IdProd')!='') {
                        $idbedido = $tabPedido->where('id',$request->get('IdProd'))->first();
                        $idbPedido = $idbedido->id;
                    } else {
                        $idbPedido = $tabPedido->where('id_encomenda',session('idEncomenda'))->max('id');

                    }
                    $linhaArtigo = DB::table('lista_de_pedidos')->where('id',$idbPedido)->first();
                    // A calcular o total da linha
                    $totalLinha = $linhaArtigo->quantidade * str_replace(' ','',$request->get('numeros'));
                    // A inceri as inforrmaçoes no banco de dados
                    $incerir = DB::table('lista_de_pedidos')->where('id',$linhaArtigo->id)->update([
                        'preco_venda'=>str_replace(' ','',$request->get('numeros')),
                        'total'=>$totalLinha,
                    ]);
                    // A calcular total desta encomenda
                    $totals = $tabPedido->where('id_encomenda',$linhaArtigo->id_encomenda)->sum('total');
                    DB::table('encomendas_pos')->where('id',$linhaArtigo->id_encomenda)->update([
                        'total'=>$totals,
                    ]);
                }
            }

        } else {
            // A verivicar se existe id
            if ($request->get('IdProd')!='') {

                // A verificar se a quantidade pedido e suficiente

                $tabPedidos = $tabPedido->all()->where('id',$request->get('IdProd'))->first();

                // A selectionar a caixa relationado
                $caixa = DB::table('caixas')->where('id',session('id_caixa'))->first();
                // A verificar se esta tem um armagen relationado
                if ($caixa->Armagen !='') {

                     // A selectionar produto pelo id recebido
                     $product = $tabPedido
                     ->where('id_artigo',$tabPedidos->id_artigo)
                     ->where('estado','Cotaçao')
                     ->where('armagen',$tabPedidos->armagen)
                     ->sum('quantidade');
                    // A selectionar stock deste artigo correspondente a este armagen
                    $stock = DB::table('stocks')->where('IdArmagen',$caixa->Armagen)->where('IdArtigo',$tabPedidos->id_artigo);
                    // A verificar se este artigo esta relationado com este armagen
                    if ($stock->count()>0) {
                        // A selectionar Produto
                        $produto = produtos::find($tabPedidos->id_artigo);
                        $VerifQuantidade = $product - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // A verificar a quantidade
                        if ($stock->first()->quantidade >= $VerifQuantidade) {
                            // A calcular preços e total
                            // A selectionar o produto
                            $produto = DB::table('produtos')->where('id',$produto->id)->first();
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }
                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;


                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();
                        } else {
                            echo '<div class="alert alert-danger">Atenção este artigo não tem quantidade suficiente neste armagen <strong> STOCK REAL : '.$stock->first()->quantidade.'</strong> !!!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info"> Atenção este artigo não esta relationado com este armagen !!!</div>';
                    }

                } else {
                     // A selectionar produto pelo id recebido
                    $product = $tabPedido
                    ->where('id_artigo',$tabPedidos->id_artigo)
                    ->where('estado','Cotaçao')
                    ->sum('quantidade');

                    // A selectionar na tabelo artigos detalhados
                    $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$tabPedidos->id_artigo);
                    // A verificar se o resultados e maior do que zero
                    if ($detalho->count() > 0) {
                    // A quantidade encontrado
                        $quantidadeEncontrado = $detalho->first()->QuantidadeTemporaria;
                        /// a calcular quntidade para mandar no banco de dados
                        $quantidadeReal = $quantidadeEncontrado - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // a selectionar o produto correspondente
                        $produtoCorespond = DB::table('produtos')->where('id',$detalho->first()->idArtigoPrincipal)->first();
                        // A calcular a quantidade de artigo principal por detalho
                        $quantidadePorDetalho = $produtoCorespond->qtd * $detalho->first()->Quantidade;
                        // A fazer a verificaçao da quantidade principal por detalho
                        if ($quantidadePorDetalho >= $quantidadeReal ) {
                            DB::table('artigos_detalhados')->where('id',$detalho->first()->id)->update([
                                'QuantidadeTemporaria'=>$quantidadeReal,
                            ]);
                            // A selectionar o produto
                            $produto = DB::table('produtos')->where('id',$tabPedidos->id_artigo)->first();
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }

                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;
                            // A fazer update da linha no banco

                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();
                        } else {
                            echo '<div class="alert alert-danger">Atenção o artigo principal <strong>'.$produtoCorespond->nome.'</strong> não tem quantidade suficiente !!!</div>';
                        }

                    } else {
                        // A selectionar Produto
                        $produto = produtos::find($tabPedidos->id_artigo);
                        $VerifQuantidade = $product - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // A verificar a quantidade
                        if ($produto->qtd >= $VerifQuantidade) {
                            // A calcular preços e total
                            // A selectionar o produto
                            $produto = DB::table('produtos')->where('id',$produto->id)->first();
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }
                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;


                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();
                        } else {
                            echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente <strong>'.$produto->qtd.'</strong> !!!</div>';
                        }
                    }
                }
            } else {
                // A qui nao exist id
                $idbPedido = $tabPedido->where('id_encomenda',session('idEncomenda'))->max('id');
                $tabPedidos = $tabPedido::find($idbPedido);
                // A selectionar a caixa relationado
                $caixa = DB::table('caixas')->where('id',session('id_caixa'))->first();
                // A verificar se esta tem um armagen relationado
                if ($caixa->Armagen !='') {

                    // A selectionar produto pelo id recebido
                    $product = $tabPedido
                     ->where('id_artigo',$tabPedidos->id_artigo)
                     ->where('estado','Cotaçao')
                     ->where('armagen',$tabPedidos->armagen)
                     ->sum('quantidade');
                    // A selectionar stock deste artigo correspondente a este armagen
                    $stock = DB::table('stocks')->where('IdArmagen',$caixa->Armagen)->where('IdArtigo',$tabPedidos->id_artigo);
                    // A verificar se este artigo esta relationado com este armagen
                    if ($stock->count()>0) {
                        // A selectionar Produto
                        $produto = produtos::find($tabPedidos->id_artigo);
                        $VerifQuantidade = $product - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // A verificar a quantidade
                        if ($stock->first()->quantidade >= $VerifQuantidade) {
                            // A calcular preços e total
                            // A selectionar o produto
                            $produto = DB::table('produtos')->where('id',$produto->id)->first();
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }
                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;


                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();
                        } else {
                            echo '<div class="alert alert-danger">Atenção este artigo não tem quantidade suficiente neste armagen <strong> STOCK REAL : '.$stock->first()->quantidade.'</strong> !!!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info"> Atenção este artigo não esta relationado com este armagen !!!</div>';
                    }
                }else{
                    // A selectionar produto pelo id recebido
                    $product = $tabPedido
                    ->where('id_artigo',$tabPedidos->id_artigo)
                    ->where('estado','Cotaçao')
                    ->sum('quantidade');

                    // A selectionar na tabelo artigos detalhados
                    $detalho = DB::table('artigos_detalhados')->where('idArtigodetalhado',$tabPedidos->id_artigo);
                    // A verificar se o resultados e maior do que zero
                    if ($detalho->count() > 0) {



                        // A quantidade encontrado
                        $quantidadeEncontrado = $detalho->first()->QuantidadeTemporaria;
                        /// a calcular quntidade para mandar no banco de dados
                        $quantidadeReal = $quantidadeEncontrado - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // a selectionar o produto correspondente
                        $produtoCorespond = DB::table('produtos')->where('id',$detalho->first()->idArtigoPrincipal)->first();
                        // A calcular a quantidade de artigo principal por detalho
                        $quantidadePorDetalho = $produtoCorespond->qtd * $detalho->first()->Quantidade;
                        // A fazer a verificaçao da quantidade principal por detalho
                        if ($quantidadePorDetalho >= $quantidadeReal ) {
                            DB::table('artigos_detalhados')->where('id',$detalho->first()->id)->update([
                                'QuantidadeTemporaria'=>$quantidadeReal,
                            ]);
                            // A selectionar o produto
                            $produto = DB::table('produtos')->where('id',$tabPedidos->id_artigo)->first();
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }

                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;

                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();
                        } else {
                            echo '<div class="alert alert-danger">Atenção o artigo principal <strong>'.$produtoCorespond->nome.'</strong> não tem quantidade suficiente !!!</div>';
                        }
                    } else{
                        // A selectionar Produto
                        $produto = produtos::find($tabPedidos->id_artigo);
                        $VerifQuantidade = $product - $tabPedidos->quantidade + str_replace(' ','',$request->get('numeros'));
                        // A verificar a quantidade
                        if ($produto->qtd >= $VerifQuantidade) {

                            // A selectionar o produto
                            // A veririfiacr se o artigo clicado tem desconto
                            $listPrice = DB::table('lista_de_preco')->where('id_produto',$produto->id);
                            // A verificar se tem uma linha afetada
                            if ($listPrice->count() >0) {
                                // A verificar a quantidade encontrada
                                if ($listPrice->first()->quantidade <= str_replace(' ','',$request->get('numeros'))) {
                                    $preco = $listPrice->first()->preco_de_desconto;
                                    $total = str_replace(' ','',$request->get('numeros')) * $listPrice->first()->preco_de_desconto - $tabPedidos->total_desconto;
                                }else{
                                    $preco = $produto->preçovenda;
                                    $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;                            }
                            } else {
                                $preco = $produto->preçovenda;
                                $total = str_replace(' ','',$request->get('numeros')) * $produto->preçovenda - $tabPedidos->total_desconto;
                            }

                            $totalCusto = str_replace(' ','',$request->get('numeros')) * $produto->preçocust;


                            $total_desconto = str_replace(' ','',$request->get('numeros')) *  $tabPedidos->desconto;
                            $tabPedidos->quantidade = str_replace(' ','',$request->get('numeros'));
                            $tabPedidos->preco_venda = $preco;
                            $tabPedidos->total = $total;
                            $tabPedidos->TotalCusto = $totalCusto;
                            $tabPedidos->total_desconto = $total_desconto;
                            $tabPedidos->update();
                            // A mendar total no banco de dados
                            $tabEncomend = $tabEncomenda::find($tabPedidos->id_encomenda);
                            // A calcular total desta encomenda
                            $totals = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total');
                            $desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('desconto');
                            $total_desconto = $tabPedidos->where('id_encomenda',$tabEncomend->id)->sum('total_desconto');
                            $tabEncomend->total = $totals;
                            $tabEncomend->desconto = $desconto;
                            $tabEncomend->total_desconto = $total_desconto;
                            $tabEncomend->update();

                        } else {

                            echo '<div class="alert alert-danger">Atenção a quatidade deste artigo nao e suficiente <strong>'.$produto->qtd.'</strong> !!!</div>';
                        }
                    }
                }
            }

        }
    }
}
