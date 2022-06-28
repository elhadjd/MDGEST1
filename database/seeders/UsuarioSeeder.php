<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_usuariolog')->insert([
            'apelido'=>'Administrador',
            'email'=>'admin@gmail.com',
            'nivel'=>'Administrador',
            'senha'=>'123456',
            'estado'=>'Ativo',
            'nome_completo'=>'Administrador',
            'id_responsavel'=>'1',
            'id_empresa'=>'1',
        ]);
    }
}
