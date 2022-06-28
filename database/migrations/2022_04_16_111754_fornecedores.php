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
        Schema::create('fornecedores',function(Blueprint $table){
            $table->id();
            $table->string('nome',null)->nullable()->default(null);
            $table->string('telefone',null)->nullable()->default(null);
            $table->string('imagem',null)->nullable()->default(null);
            $table->string('tipo_fornecedor',null)->nullable()->default(null);
            $table->string('data',null)->nullable()->default(null);
            $table->string('email',null)->nullable()->default(null);
            $table->string('pais',null)->nullable()->default(null);
            $table->string('cidade',null)->nullable()->default(null);
            $table->string('sede',null)->nullable()->default(null);
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
