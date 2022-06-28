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
        Schema::create('empresas',function(Blueprint $table){
            $table->id();
            $table->string('imagem')->nullable()->default(null);
            $table->string('nome_de_empresa')->nullable()->default(null);
            $table->string('nif_empresa')->nullable()->default(null);
            $table->string('cidade')->nullable()->default(null);
            $table->string('sede')->nullable()->default(null);
            $table->string('numero_de_casa')->nullable()->default(null);
            $table->string('tipo_de_atividade')->nullable()->default(null);
            $table->timestamp('data')->nullable()->default(null);
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
