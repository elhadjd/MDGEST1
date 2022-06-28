<?php

namespace App\Http\Controllers;

use App\Http\Controllers\tb_usuariolog as ControllersTb_usuariolog;
use App\Models\tb_usuariolog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

class ConfigController extends Controller
{
    //
    public function MenuConfig(Request $request)
    {
        # code...
        if (!session('logado')) {
            return view('login.index');
        }else{
            $empresa = DB::table('empresas')->get();
            $app = DB::table('apps')->where('estado','Ativo')->orderBy('id','ASC')->get();
            $user = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
            $acs = DB::table('acces_App')->where('id_usuario',$user->id)->where('id_modulo',$request->get('id_app'))->count();
            if ($acs!=0) {
                if ($request->get('menu')) {
                    $users = DB::table('tb_usuariolog')->count();
                    $app_ativo = DB::table('apps')->where('estado','Ativo')->count();
                    return view('configuracoes.MenuConfig',[
                        'total_app'=>$app_ativo,
                        'users'=>$users,
                    ]);
                }elseif($request->get('empresa')){
                    return view('configuracoes.empresa',[
                        'empresas'=>$empresa,
                        'user'=>$user,
                        'app'=>$app,
                    ]);
                }else{
                    return view('configuracoes.ComfigHome',[
                        'user'=>$user,
                        'app'=>$app,
                    ]);
                }
            }else{
                return '<div class="alert alert-danger">Não autorizado</div>';
            }
        }
    }
    public function ListUser()
    {
        # code...
        $verifiq = DB::table('empresas')->count();
        if ($verifiq > 0) {
            $empres = DB::table('empresas')->first();
            $empresa = $empres->nome_de_empresa;
        }else{
            $empresa = '';
        }
        $user = DB::table('tb_usuariolog')->get();
        return view('configuracoes.usuarios',[
            'users'=>$user,
            'empresa'=>$empresa
        ]);
    }
    public function bloco_usuario(Request $request)
    {
        # code...
        if ($request->get('id_user')=='') {
            $data = date('Y-m-d H:m:i');
            $inserUser = DB::table('tb_usuariolog')->insertGetId([
                'id_responsavel'=>session('id_admin'),
                'data'=>$data,
                'imagem'=>'img.png',
                'estado'=>'Ativo'
            ]);
            $usuario = DB::table("tb_usuariolog")->where('id',$inserUser)->first();
        }else{
            $usuario = DB::table("tb_usuariolog")->where('id',$request->get('id_user'))->first();
        }
        return view('configuracoes.novo_user',[
            'usuario'=>$usuario,
        ]);
    }
    public function info_user_creat(Request $request)
    {
        # code...
        // a verificar se existe id deste usuario na tabela info usr
        $verificar = DB::table('info_user')->where('id_user',$request->get('id_user'))->count();
        if($verificar > 0){
        if ($request->get('palavra')){
            // A modificar as informaçoes de usuario
            $update = DB::table('info_user')->where('id_user',$request->get('id_user_bloco'))->update([
                $request->get('table')=>$request->get('palavra'),
            ]);
        }elseif ($request->get('ko_mintun')) {
            # code...
            $senha = Crypt::encryptString($request->get('ko_mintun'));
            $updat = DB::table('tb_usuariolog')->where('id',$request->get('id_user_bloco'))->update([
                'senha'=>$senha,
            ]);
        }
        }else{
            $data = date('Y-m-d');
            $insert = DB::table('info_user')->insertGetId([
                'id_user'=>$request->get('id_user'),
                'data'=>$data,
            ]);
        }
        // A mandar nome e email de usuario no sistema
        if ($request->get('escrever_nome_email')) {
            // A mandar nome email apelido no banco de dados
            $editar = DB::table('tb_usuariolog')->where('id',$request->get('id_bloco_usere'))->update([
                $request->get('coluna')=>$request->get('escrever_nome_email')
            ]);
        }
        // A mandar nivel de usuario no banco
        if ($request->get('nivel')) {
            $editar = DB::table('tb_usuariolog')->where('id',$request->get('id_bloco_usere'))->update([
                $request->get('coluna')=>$request->get('nivel')
            ]);
        }
        if ($request->get('estado_genero')) {
            $editar = DB::table('info_user')->where('id',$request->get('id_usuario'))->update([
                $request->get('coluna')=>$request->get('estado_genero')
            ]);
        }
        $app = DB::table('apps')->get();
        $user = DB::table('tb_usuariolog')->where('id',$request->get('id_user'))->first();
        $info = DB::table('info_user')->where('id_user',$request->get('id_user'))->first();
        return view('configuracoes.info_user',[
            'user'=>$user,
            'app'=>$app,
            'tipo_info'=>$request->get('tipo'),
            'info'=>$info,
        ]);
    }
    public function accessApp(Request $request)
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
        $verifica = DB::table('acces_App')->where('id_usuario',$request->get('idUser'))->where('id_modulo',$request->get('IdApp'))->count();
        if ($verifica > 0) {
            Db::table('acces_App')->where('id_usuario',$request->get('idUser'))->where('id_modulo',$request->get('IdApp'))->update([
                'id_responsavel'=>session('id_admin'),
                'id_modulo'=>$request->get('IdApp'),
                'id_usuario'=>$request->get('idUser'),
                'tipo_de_acesso'=>$request->get('tipoAcces'),
            ]);
        }else{
            $data = date('Y-m-d H:m:i');
            Db::table('acces_App')->insertGetId([
                'id_responsavel'=>session('id_admin'),
                'id_modulo'=>$request->get('IdApp'),
                'id_usuario'=>$request->get('idUser'),
                'tipo_de_acesso'=>$request->get('tipoAcces'),
                'dia'=>$dia,
                'mes'=>$mes,
                'anno'=>$anno,
                'data'=>$data
            ]);
        }
    }
    public function AcoesUser(Request $request , tb_usuariolog $updat_user)
    {
        $conect = DB::table('tb_usuariolog')->where('id',session('id_admin'))->first();
        if (str_replace(' ','',$conect->nivel)!='Administrador') {
            echo '<div class="alert alert-danger">Usuario sem permissão</div>';
        }else{
            if ($request->get('TipoAção') == "Arquivar")
            {
                DB::table('tb_usuariolog')->where('id',$request->get('id_user'))->update([
                    'estado'=>'Inativo',
                ]);
                return '<div class="alert alert-success">Usuario arquivado som successo !!!</div>';
            }
            elseif ($request->get('TipoAção') == 'Apagar')
            {
                DB::table('tb_usuariolog')->where('id',$request->get('id_user'))->delete();
                return '<div class="alert alert-success">Usuario eliminado com successo !!!</div>';
            }
            elseif($request->get('TipoAção') == 'Restorar')
            {
                DB::table('tb_usuariolog')->where('id',$request->get('id_user'))->update([
                    'estado'=>'Ativo',
                ]);
                return '<div class="alert alert-success">Usuario restourado com successo !!!</div>';
            }
        }
    }
}
