<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('acces_App')->insert([
            'id_responsavel'=>'1',
            'id_modulo'=>'1',
            'id_usuario'=>'1',
            'tipo_de_acesso'=>'Administrador',

        ]);
    }
}
