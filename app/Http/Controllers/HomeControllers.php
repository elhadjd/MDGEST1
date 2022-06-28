<?php

namespace App\Http\Controllers;

use App\Models\DataMuvementoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeControllers extends Controller
{
    //
    public function index(Request $request, DataMuvementoModel $dataMuvemento)
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
        if (!session('logado')) {
            return view('login.index',[
                'menssagem'=>$request->get('menssagem'),
            ]);
        }elseif(session('logado')){
            if ($request->get('sair')) {
                session(['id_admin'=>'']);
                session(['logado'=>false]);
            }else{
                // A verificar se a data dde muvementos enta preenchida
                $dataMuv = DB::table('data_muvemento_models')
                ->whereDay('created_at',date('d'))
                ->WhereMonth('created_at',date('m'))
                ->WhereYear('created_at',date('Y'));
                // A verificar
                if ($dataMuv->count()<1) {
                    $dataMuvemento->idResponsavel = session('id_admin');
                    $dataMuvemento->dia = $dia;
                    $dataMuvemento->mes = $mes;
                    $dataMuvemento->ano = $anno;
                    $dataMuvemento->save();
                }
                // A inserir na data de muvementos
                $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
                $app = DB::table('apps')->where('estado','Ativo')->orderBy('app_name','ASC')->get();
                return view('homeApp',[
                    'app'=>$app,
                    'user'=>$user
                ]);
            }

        }
    }
}
