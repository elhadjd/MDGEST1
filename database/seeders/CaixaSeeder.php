<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaixaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('caixas')->insert([
            'nome'=>'Shop',
            'id_admin'=>'1',
            'estado'=>'Ativo',
            'id_user_relation'=>'1',
            'impresaoCliente'=>'false',
        ]);
    }
}
