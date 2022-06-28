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
        Schema::create('pagamentos_de_compras', function(Blueprint $table){
            $table->id();
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->integer('id_tipo_de_pagamentos')->nullable()->default(null);
            $table->integer('id_da_orden')->nullable()->default(null);
            $table->integer('id_fornecedor')->nullable()->default(null);
            $table->float('valor_pago')->nullable()->default(null);
            $table->float('total_da_orden')->nullable()->default(null);
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
