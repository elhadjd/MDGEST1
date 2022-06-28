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
        Schema::create('muvementos_de_stock', function(Blueprint $table){
            $table->id();
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->integer('id_do_artigo')->nullable()->default(null);
            $table->integer('id_da_orden')->nullable()->default(null);
            $table->integer('quantidade')->nullable()->default(null);
            $table->string('tipo_de_operacao')->nullable()->default(null);
            $table->string('idArmagen')->nullable()->default(null);
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
    }
};
