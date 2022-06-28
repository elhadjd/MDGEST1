<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tipofatura extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_fatura_models')->insert([
            'nome'=>'Pronto pagamento',
        ]);
        DB::table('tipo_fatura_models')->insert([
            'nome'=>'Prestação',
        ]);
        DB::table('tipo_fatura_models')->insert([
            'nome'=>'Credito',
        ]);
        DB::table('tipo_fatura_models')->insert([
            'nome'=>'Por forma',
        ]);
    }
}
