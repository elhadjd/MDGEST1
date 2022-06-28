<?php

namespace App\Http\Controllers;

use App\Models\pagamentos as ModelsPagamentos;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pagamentos extends Controller
{
    //
    public function tela_de_pagemento(Request $request)
    {
        $orden = DB::table($request->get('table'))
                                                ->where('id',$request->get('id_orden'))
                                                ->first();
        // A selectionar os pagamento da orden
        $pagamentos = DB::table('pagamentos_de_compras')
                                                    ->where('id_da_orden',$_GET['id_orden'])
                                                    ->sum('valor_pago');
        $resto = $orden->total - $pagamentos;
        return view('pagamentos.pagamentos',[
            'orden'=>$orden,
            'a_pagar'=>$resto
        ]);
    }

    // A efectuar pagamento
    public function fazer_pagamento(Request $request)
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
        $total = substr($request->get('a_pagar'),0,-3);
        if ($request->get('method')=="") {
            echo '<div class="alert alert-danger">Por favor enforme o methodo de pagamento !!!</div>';
        }elseif($request->get('valor_enformado')==''){
            echo '<div class="alert alert-danger">Por favor enforme valor !!!</div>';
        }else{
            if (!is_numeric($request->get('valor_enformado'))) {
                echo '<div class="alert alert-danger">
                Valor enformado não e valido por favor inform valor apenas com numeros!!!
                </div>';
            }else{
                $method = DB::table('methodo_de_pagamento')
                ->where('nome',$request->get('method'))
                ->first();
            $orden = DB::table($request->get('table_a_tirar'))
                ->where('id',$request->get('id_orden'))
                ->first();
            $inserir = DB::table($request->get('table_a_enviar'))->insert([
                'id_responsavel'=>session('id'),
                'id_tipo_de_pagamentos'=>$method->id,
                'id_da_orden'=>$request->get('id_orden'),
                'valor_pago'=>$request->get('valor_enformado'),
                'total_da_orden'=>$total,
                'id_fornecedor'=>$orden->id_fornecedor,
                'dia'=>$dia,
                'mes'=>$mes,
                'anno'=>$anno,
                'data'=>$data
                ]);
                $resto = $total - $request->get('valor_enformado');
                echo '<div class="alert alert-success">Pagamento efectuado com successo !!! </div>';
                if ($resto <= 0) {
                    $orden = DB::table($request->get('table_a_tirar'))
                    ->where('id',$request->get('id_orden'))
                    ->update([
                        'estado'=>'Pago',
                    ]);
                }
            }
        }  
    }
    public function buscar_pagamentos(Request $request)
    {
       if($request->get('pagamento_id'))
       {
        $orden = DB::table('listcompra')->where('id',$request->get('pagamento_id'))->first();
        $pagamento = DB::table('pagamentos_de_compras')->where('id_da_orden',$request->get('pagamento_id'))->get();
        echo '<div class="text-secondary form-control h-25 overflow-auto">';
        for ($i=0; $i <sizeof($pagamento) ; $i++):
            $pagamentos = $pagamento[$i];
            $method = DB::table('methodo_de_pagamento')->where('id',$pagamentos->id_tipo_de_pagamentos)->first();
            $resto = $pagamentos->total_da_orden - $pagamentos->valor_pago;
            echo '
            <div class="muvemento_pag d-flex">
                <div><strong>Data : </strong>'.(date('d/m/Y à\s H:i:s',strtotime($pagamentos->data))).'</div>
                <div><strong>Method pagamento : </strong>'.$method->nome.'</div>
                <div><strong>Valor pago : </strong>'.number_format($pagamentos->valor_pago,2,",",".")."Kz".'</div>
                <div><strong>Total apos pagamento : </strong>'.number_format($resto,2,",",".")."Kz".'</div>
            </div>';
       endfor;
    //    if (str_replace(' ','',$orden->estado) !="Pago") {
    //        echo '<div class="btn add_pag" id="{{$item->id}}">Adicionar pagamento</div>';
    //     }
       echo '</div>';
        }elseif($request->get('num_orden')){
        $pagamentos = DB::table('listcompra')->where('referencia','LIKE','%'.$request->get('num_orden').'%')->limit(10)->get();
        return view('pagamentos.pesquisar',[
            'pagamentos'=>$pagamentos,
        ]);
        exit();
        }else{
            $totais = DB::table('listcompra')->sum('total');
            $pago = DB::table('pagamentos_de_compras')->sum('valor_pago');
                $lista_de_orden = DB::table('listcompra')->orderBy('id','DESC')->limit(20)->get();
                $a_pagar = $totais - $pago;
            return view('pagamentos.lista_de_pagamentos',[
                'lista_de_orden'=>$lista_de_orden,
                'totais'=>$totais,
                'pago'=>$pago,
                'a_pagar'=>$a_pagar
            ]);
        
        }
    }
}
