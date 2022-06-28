<?php

namespace App\Http\Controllers;

use App\Models\tb_usuariolog as ModelsTb_usuariolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tb_usuariolog extends Controller
{
    //
    public function user_conect()
    {
        if (!session('logado')) {
         return view('login.index');
        }else{
            $usuario_conectado = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            return view('layotus.default',[
                'id'=>$usuario_conectado->id,
                'email_user'=>$usuario_conectado->email
            ]);
        }
    }
    public function login(Request $request)
    {
        $select_user = DB::table('tb_usuariolog')->where('email',$request->get('email'))->count();
        if ($select_user > 0) {
            $usuario = DB::table('tb_usuariolog')->where('email',$request->get('email'))->where('senha', $request->get('senha'))->count();
            if ($usuario > 0) {
                $usuario =  DB::table('tb_usuariolog')->where('email',$request->get('email'))->where('senha', $request->get('senha'))->first();
                session(['id_admin'=>$usuario->id]);
                session(['logado'=>true]);
            }else{
                session(['id_admin'=>'']);
                session(['logado'=>false]);
                echo 'Email ou a senha incorreta por favor verifique e tenta novamente!!!';
            }
        }else{
            echo 'Usuario com este email ('.$request->get('email').') nao existe por favor verifique e tenta novamente!!!';
        }
    }
}
