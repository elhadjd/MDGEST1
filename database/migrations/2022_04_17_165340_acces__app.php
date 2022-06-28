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
        Schema::create('acces_App',function(Blueprint $table){
            $table->id();
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->integer('id_modulo')->nullable()->default(null);
            $table->integer('id_usuario')->nullable()->default(null);
            $table->string('tipo_de_acesso')->nullable()->default(null);
            $table->string('dia')->nullable()->default(null);
            $table->string('mes')->nullable()->default(null);
            $table->string('anno')->nullable()->default(null);
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
        Schema::dropIfExists('acces_App');
    }
};
