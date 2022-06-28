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
        Schema::create('lista_de_pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_encomenda')->nullable()->default(null);
            $table->integer('id_session')->nullable()->default(null);
            $table->integer('id_artigo')->nullable()->default(null);
            $table->string('pos_ativo')->nullable()->default(null);
            $table->integer('id_caixa')->nullable()->default(null);
            $table->integer('armagen')->nullable()->default(null);
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->float('preco_venda')->nullable()->default(null);
            $table->float('preco_custo')->nullable()->default(null);
            $table->integer('desconto')->nullable()->default(null);
            $table->float('TotalCusto')->nullable()->default(null);
            $table->float('total_desconto')->nullable()->default(null);
            $table->integer('quantidade')->nullable()->default(null);
            $table->float('total')->nullable()->default(null);
            $table->string('dia')->nullable()->default(null);
            $table->string('mes')->nullable()->default(null);
            $table->string('ano')->nullable()->default(null);
            $table->string('estado')->nullable()->default(null);
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
        Schema::dropIfExists('lista_de_pedidos');
    }
};
