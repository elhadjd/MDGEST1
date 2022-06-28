<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethoPagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('methodo_de_pagamento')->insert([
            'nome'=>'Numerario',
        ]);
        DB::table('methodo_de_pagamento')->insert([
            'nome'=>'Transferencia',
        ]);
        DB::table('methodo_de_pagamento')->insert([
            'nome'=>'Multicaixa',
        ]);
    }
}
