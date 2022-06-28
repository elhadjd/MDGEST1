<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('lista_de_preco',function(Blueprint $table){
            $table->id();
            $table->integer('id_produto')->nullable()->default(NULL);
            $table->integer('id_responsavel')->nullable()->default(NULL);
            $table->integer('quantidade')->nullable()->default(NULL);
            $table->float('preco_de_desconto')->nullable()->default(NULL);
            $table->timestamp('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
