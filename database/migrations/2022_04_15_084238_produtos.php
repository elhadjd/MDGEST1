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
        Schema::create('produtos',function(Blueprint $table){
            $table->id();
            $table->string('nome')->nullable()->default(NULL);
            $table->string('imagem')->nullable()->default(NULL);
            $table->string('codego')->nullable()->default(NULL);
            $table->string('referencia')->nullable()->default(NULL);
            $table->string('tipoartigo')->nullable()->default(NULL);
            $table->string('fabricante')->nullable()->default(NULL);
            $table->string('fornecedore')->nullable()->default(null);
            $table->integer('preçocust')->nullable()->default(NULL);
            $table->string('imposto')->nullable()->default(NULL);
            $table->string('preçovenda')->nullable()->default(NULL);
            $table->float('preco_medio')->nullable()->default(NULL);
            $table->timestamp('datafab')->nullable()->default(NULL);
            $table->timestamp('dataexp')->nullable()->default(NULL);
            $table->timestamp('data')->nullable()->default(NULL);
            $table->integer('qtd')->nullable()->default(NULL);
            $table->float('patrimonio')->nullable()->default(NULL);
            $table->float('total_cust')->nullable()->default(NULL);
            $table->rememberToken()->nullable()->default(NULL);
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
