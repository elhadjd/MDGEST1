<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encomendas_pos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_session')->nullable()->default(null);
            $table->integer('id_caixa')->nullable()->default(null);
            $table->string('pos_ativo')->nullable()->default(null);
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->integer('armagen')->nullable()->default(null);
            $table->float('total')->nullable()->default(null);
            $table->float('desconto')->nullable()->default(null);
            $table->float('total_desconto')->nullable()->default(null);
            $table->string('dia')->nullable()->default(null);
            $table->string('mes')->nullable()->default(null);
            $table->string('ano')->nullable()->default(null);
            $table->string('cliente')->nullable()->default(null);
            $table->string('estado')->nullable()->default(null);
            $table->integer('impresao')->nullable()->default(null);
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
        Schema::dropIfExists('encomendas_pos');
    }
};
