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
        Schema::create('novo_pedido_de_compra', function(Blueprint $table){
            $table->id();
            $table->integer('id_Orden')->nullable()->default(NULL);
            $table->integer('id_produto')->nullable()->default(NULL);
            $table->string('artigo')->nullable()->default(NULL);
            $table->integer('id_responsavel')->nullable()->default(NULL);
            $table->integer('quantidade')->nullable()->default(NULL);
            $table->float('total')->nullable()->default(NULL);
            $table->timestamp('data')->nullable()->default(NULL);
            $table->float('desconto')->nullable()->default(NULL);
            $table->float('custo')->nullable()->default(null);
            $table->float('total_desconto')->nullable()->default(NULL);
            $table->float('iva')->nullable()->default(NULL);
            $table->float('total_iva')->nullable()->default(NULL);
            $table->float('preco_final')->nullable()->default(null);
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
