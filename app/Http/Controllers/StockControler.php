<?php

namespace App\Http\Controllers;

use App\Models\ArmagensModel;
use App\Models\Stock;
use App\Models\transferencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class StockControler extends Controller
{
    //
    public function Stock()
    {
        if (!session('logado')) {
            return view('login.index');
        }else{
            $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('Stock.app',[
                'user'=>$user,
                'app'=>$app
            ]);
        }
    }
    public function MenuStock(Request $request)
    {
        if ($request->get('IdArmagen')) {
            $stock = DB::table('stocks')->where('IdArmagen',$request->get('IdArmagen'))->get();
            return view('Stock.StockArtigo',[
                'Stock'=>$stock
            ]);
        }else{
            // A selectionar todos os armagens
            $armagen = ArmagensModel::all();
            return view('Stock.HomeStock',[
                'Armagens'=>$armagen
            ]);
        }

    }
    public function Armagens(ArmagensModel $armagens)
    {
        // $armagens->where('NomeArmagen',null)->delete();
        // A selectionar todos os armagens
        $armagen = ArmagensModel::all();
        return view('Stock.Armagens',[
            'Armagens'=>$armagen
        ]);
    }
    public function GuardarArmagen (Request $request,ArmagensModel $armagens)
    {
        if($request->get('IdArmagem')){
            $armagen = $armagens->where('id',$request->get('IdArmagem'))->first();
            $array[] = array('nome'=>$armagen->NomeArmagen);
            echo json_encode($array);
        }else{
            if ($request->get('Armagem') == 'Novo') {
                $armagens->save();
                echo $armagens->id;
            } else {
                $armagen = $armagens->find($request->get('Armagem'));
                $armagen->NomeArmagen = $request->get('nomeArmagem');
                $armagen->Cidade = $request->get('CidadeArmagen');
                $armagen->Bairo = $request->get('SedeArmagen');
                $armagen->NumeroCasa = $request->get('Edificio');
                $armagen->save();
            }
        }
    }
    // A trazera os relatorios de stock
    public function RelatoriosStock(Request $request,Stock $stock , transferencias $transferencias)
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
        $tipoOperation = $request->get('tipoOperation');
        if ($tipoOperation == 'Muvementos') {
            return view('Stock.muvementos');
        } elseif ($tipoOperation == 'Transferencias') {
            return view('Stock.Tranferencias');
        } else{
            if ($request->get('lista') == 'CrearTransferencia') {
                $transferencias->Responsavel = session('id_admin');
                $transferencias->save();
                $id = $transferencias->id;
                return view('Stock.Tranferencias',[
                    'IdTransferencia'=>$id
                ]);
            }elseif($request->get('lista') == 'Pesqqquisar'){
                $resultado = DB::table(str_replace('1','',$request->get('tabela')))
                ->where($request->get('coluna'),'LIKE','%'.$request->get('palavra').'%')
                ->get();
                for ($i=0; $i <sizeof($resultado) ; $i++) {
                    $Armagens = $resultado[$i];
                    if ($request->get('tabela') == 'produtos') {
                        echo '<div class="border-bottom p-2 LinhasResult" IdLinha="'.$Armagens->id.'" coluna="ArtigoPrencipal" input="InputArtigo">'.$Armagens->nome.'</div>';
                    } elseif($request->get('tabela') == 'armagens_models'){
                        echo '<div class="border-bottom p-2 LinhasResult" coluna="ArmagenPrencipal" IdLinha="'.$Armagens->id.'" input="InputPrincipal">'.$Armagens->NomeArmagen.'</div>';
                    }else{
                        echo '<div class="border-bottom p-2 LinhasResult" coluna="ArmagenDestino" IdLinha="'.$Armagens->id.'" input="InputDestino">'.$Armagens->NomeArmagen.'</div>';
                    }
                }
                ?>
                <script>
                    $(".LinhasResult").click(function(){
                        var IdLinha = $(this).attr('IdLinha');
                        var coluna = $(this).attr('coluna');
                        var IdTransferencia = $(".IdMuvemento").text();
                        var nome = $(this).html();
                        var input = $("#"+$(this).attr('input'));
                        $.ajax({
                            type: "GET",
                            url : "/RelatoriosStock",
                            data : {
                                IdLinha : IdLinha,
                                IdTransferencia : IdTransferencia,
                                coluna : coluna,
                                lista : 'InserirTransferencia',
                            },
                            beforeSend : function(){
                                $(".processar").show();
                            },
                            success : function(data){
                                $(".ResultDestino").show()
                                input.val(nome)
                                $(".processar").hide();
                                $(".ResultArtigo").hide();
                                $(".ResultDestino").hide();
                                $(".ResultPrincipal").hide();
                                $(".QuantidadeDisponivel").html(data)
                            }
                        })
                    })
                </script>
                <?php
            }elseif($request->get('lista') == 'InserirTransferencia'){
                // A selectionar a linha a ser modificada
                $transferencia = DB::table('transferencias')
                ->where('id',$request->get('IdTransferencia'));
                    // A verificar tipo de id recebido
                    if ($request->get('coluna') == 'ArtigoPrencipal') {
                        if ($transferencia->first()->ArmagenPrencipal !=''){
                            // A somar  stock disponivel no armagen selectionado
                            $artigo = DB::table('stocks')
                            ->where('IdArtigo',$request->get('IdLinha'))
                            ->where('IdArmagen',$transferencia->first()->ArmagenPrencipal);
                            // A verificar se este artigo clicado existe neste armagen selectionado
                            if ($artigo->count() > 0) {
                                echo number_format($artigo->first()->quantidade,2,",",".")."Un(s)";
                            } else {
                                $stock->IdArmagen = $transferencia->first()->ArmagenPrencipal;
                                $stock->IdArtigo = $request->get('IdLinha');
                                $stock->quantidade = 0;
                                $stock->save();
                                echo number_format($stock->quantidade,2,",",".")."Un(s)";
                            }
                        }else{
                            echo '<div class="alert alert-info">Por favor selectiona o armagen principal !!!</div>';
                        }
                    }
                DB::table('transferencias')
                ->where('id',$request->get('IdTransferencia'))
                ->update([
                    $request->get('coluna')=>$request->get('IdLinha'),
                ]);
            }elseif($request->get('lista') == 'ValidarTransferencia'){
                // A selectionar a transferencia pelo id recebibo
                $transferencia = DB::table('transferencias')->where('id',$request->get('IdTransferencia'));
                // A verificar se id existe no banco de dados
                if ($transferencia->count()>0) {
                    // A verificar se o ususario selectionou um artigo para transferir
                    if ($transferencia->first()->ArmagenPrencipal !='') {
                        // A verificar se o usuario selectionou um armagen de destino
                        if ($transferencia->first()->ArmagenDestino !='') {
                            // A selectionar stock deste produtos no banco
                            $stocks = DB::table('stocks')
                            ->where('IdArmagen',$transferencia->first()->ArmagenPrencipal)
                            ->where('IdArtigo',$transferencia->first()->ArtigoPrencipal)->first();
                            // A Verificar disponibiliodade de estock deste produte neste armagen encontrado
                            if ($stocks->quantidade >= $request->get('quantidadeTransfer')) {
                                //A selectionar o armagen de destino
                                $destino = DB::table('stocks')
                                ->where('IdArmagen',$transferencia->first()->ArmagenDestino)
                                ->where('IdArtigo',$transferencia->first()->ArtigoPrencipal);
                                //A verificar se ixist um registro do armagen de destino na tabela stocks
                                // A verificar se o usuario inseriou quantidade
                                if ($request->get('quantidadeTransfer') !='') {
                                    if ($destino->count() > 0) {
                                        // tudo serto
                                        // a enviar a quantidade
                                        // echo $destino->first()->quantidade + $request->get('quantidadeTransfer');
                                        DB::table('stocks')
                                        ->where('IdArmagen',$transferencia->first()->ArmagenDestino)
                                        ->where('IdArtigo',$transferencia->first()->ArtigoPrencipal)
                                        ->update([
                                            'quantidade'=>$destino->first()->quantidade + $request->get('quantidadeTransfer')
                                        ]);
                                        // A retirar quantidade no armagen principal
                                        DB::table('stocks')
                                        ->where('IdArmagen',$transferencia->first()->ArmagenPrencipal)
                                        ->where('IdArtigo',$transferencia->first()->ArtigoPrencipal)
                                        ->update([
                                            'quantidade'=>$stocks->quantidade - $request->get('quantidadeTransfer')
                                        ]);
                                        // A inserir nos muvementos
                                        DB::table('muvementos_de_stock')->insert([
                                            'id_responsavel'=>session('id_admin'),
                                            'id_do_artigo'=>$transferencia->first()->ArtigoPrencipal,
                                            'id_da_orden'=>$transferencia->first()->id,
                                            'quantidade'=>$request->get('quantidadeTransfer'),
                                            'tipo_de_operacao'=>'Transferencia',
                                            'dia'=>$dia,
                                            'mes'=>$mes,
                                            'anno'=>$anno,
                                            'data'=>now(),
                                            'idArmagen'=>$transferencia->first()->ArmagenDestino,
                                        ]);
                                        echo '<div class="alert alert-success">Transferencia efectuada com success !!!</div>';
                                    } else {
                                        $stock->IdArmagen = $transferencia->first()->ArmagenDestino;
                                        $stock->IdArtigo = $transferencia->first()->ArtigoPrencipal;
                                        $stock->quantidade = $request->get('quantidadeTransfer');
                                        $stock->save();
                                        DB::table('muvementos_de_stock')->insert([
                                            'id_responsavel'=>session('id_admin'),
                                            'id_do_artigo'=>$transferencia->first()->ArtigoPrencipal,
                                            'id_da_orden'=>$transferencia->first()->id,
                                            'quantidade'=>$request->get('quantidadeTransfer'),
                                            'tipo_de_operacao'=>'Transferencia',
                                            'dia'=>$dia,
                                            'mes'=>$mes,
                                            'anno'=>$anno,
                                            'data'=>now(),
                                            'idArmagen'=>$transferencia->first()->ArmagenDestino,
                                        ]);
                                        echo '<div class="alert alert-success">Transferencia efectuada com success 1!!!</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-info">Atenão o campo quantidade nao pode ficar vazio!!!</div>';
                                }
                            }else{
                                echo '<div class="alert alert-danger">Atenção a quantidade informado e maor do que a quantidade disponivel neste armagen !!!</div>';
                            }
                        } else {
                            echo '<div class="alert alert-info">Por favor selectiona o armagen de destino !!!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info">Por favor selectiona um artigo !!!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Operação invalida !!!</div>';
                }

            }
        }
    }
    //A buscar a lista dos muvementos de stock
    public function BuscarMuvementosStock(Request $request)
    {
        // A verificar tipo de lista
        if ($request->get('lista') =='Toda') {
            $muvementos = DB::table('muvementos_de_stock')->orderBy('id','DESC')->paginate(100);
        } else{
            if ($request->get('coluna')) {
                $muvementos = DB::table('muvementos_de_stock')->where($request->get('coluna'),$request->get('lista'))->orderBy('id','DESC')->limit(100)->get();
            } else {
                $responsave = DB::table('tb_usuariolog')->where('apelido','LIKE','%'.$request->get('lista').'%');
                $armage = DB::table('armagens_models')->where('NomeArmagen','LIKE','%'.$request->get('lista').'%');

                if ($responsave->count()>0) {
                    $responsavel = $responsave->first()->id;
                }else{
                    $responsavel = 0;
                }
                if ($armage->count()>0) {
                    $armagen = $armage->first()->id;
                }else{
                    $armagen = 0;
                }
                $muvementos = DB::table('muvementos_de_stock')
                ->orWhere('id_responsavel',$responsavel)
                ->orWhere('idArmagen',$armagen)
                ->orWhere('tipo_de_operacao','Like','%'.$request->get('lista').'%')
                ->get();
            }
        }
        return view('pesquisas',[
            'muvementos'=>$muvementos,
        ]);
    }
}
