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
        Schema::create('listcompra',function(Blueprint $table){
            $table->id();
            $table->string('nome')->nullable()->default(NULL);
            $table->string('referencia')->nullable()->default(NULL);
            $table->string('id_fornecedor')->nullable()->default(NULL);
            $table->integer('id_responsavel')->nullable()->default(NULL);
            $table->integer('IdArmagen')->nullable()->default(NULL);
            $table->float('total')->nullable()->default(NULL);
            $table->timestamp('data')->nullable()->default(NULL);
            $table->string('dia')->nullable()->default(NULL);
            $table->string('mes')->nullable()->default(NULL);
            $table->string('anno')->nullable()->default(NULL);
            $table->string('estado')->nullable()->default(NULL);
            $table->float('preco_final')->nullable()->default(null);
            $table->float('total_desconto')->nullable()->default(null);
            $table->float('total_iva')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
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
