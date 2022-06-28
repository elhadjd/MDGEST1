<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('apps')->insert([
            'app_name'=>'Ponto de venda',
            'id_responsavel'=>'1',
            'estado'=>'Ativo',
            'empresa'=>'1',
        ]);
        DB::table('apps')->insert([
            'app_name'=>'Compra',
            'id_responsavel'=>'1',
            'estado'=>'Ativo',
            'empresa'=>'1',
        ]);
        DB::table('apps')->insert([
            'app_name'=>'Stock',
            'id_responsavel'=>'1',
            'estado'=>'Ativo',
            'empresa'=>'1',
        ]);
        DB::table('apps')->insert([
            'app_name'=>'Configuraçoes',
            'id_responsavel'=>'1',
            'estado'=>'Ativo',
            'empresa'=>'1',
        ]);
    }
}
