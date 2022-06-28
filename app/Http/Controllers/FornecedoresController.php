<?php

namespace App\Http\Controllers;
use App\Models\fornecedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FornecedoresController extends Controller
{
    //
    public function dados_fornecedor(){
        if ($_GET['dados_fornecedor'] == '') {
            $inserir = DB::table('fornecedores')->insertGetId([
                'imagem'=>'img_empresa_default.jpg',
            ]);
            if ($inserir) {
                $fornecedor = DB::table('fornecedores')->where('id',$inserir)->first();
                return view('fornecedores.fornecedor',[
                    'id_fornecedor'=>$fornecedor->id,
                    'imagem'=>$fornecedor->imagem
                ]);
            }
        }else{
            $fornecedor = DB::table('fornecedores')->where('id',$_GET['dados_fornecedor'])->first();
                return view('fornecedores.fornecedor',[
                    'id_fornecedor'=>$fornecedor->id,
                    'imagem'=>$fornecedor->imagem
                ]);
        }
    }
    public function cadastrar_fornecedor(Request $request)
    {
        // if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
        //     dd($request->get('imagem'));
        // }else{
            dd($request->file('imagem'));
        // }
        // $formatos_permitidos = array("jpg","png","jpeg","gif","jfif");
        // $extensao = pathinfo(file('imagem'), PATHINFO_EXTENSION);
        // if (in_array($extensao, $formatos_permitidos)) {
        // $pasta = "/imagem_fornecedor";
        // $temporario = $_FILES['imagem']['tmp_name'];
        // $novo_nome = uniqid().".$extensao";
        // if (!move_uploaded_file($temporario, $pasta.$novo_nome)) {
        // $erros[] = "ERRO ao fazer upload de imagem";
        // }
        // }

        
                // $cadastrar = DB::table('fornecedores')->where('id',$request->get('id_frn'))->update([

        // ]);
    }
}

