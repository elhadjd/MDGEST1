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
        Schema::create('sessoes_caixas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_da_caixa');
            $table->integer('id_user_responsavel');
            $table->float('saldo_de_abertura')->nullable()->default(null);
            $table->float('valor_numerario')->nullable()->default(null);
            $table->float('valor_multicaixa')->nullable()->default(null);
            $table->float('ValorEncomendas')->nullable()->default(null);
            $table->float('total_geral')->nullable()->default(null);
            $table->float('numerario_informado')->nullable()->default(null);
            $table->float('multicaixa_informado')->nullable()->default(null);
            $table->float('transferencia_informado')->nullable()->default(null);
            $table->float('total_geral_informado')->nullable()->default(null);
            $table->integer('totalEncomendas')->nullable()->default(null);
            $table->float('diferenciaErro')->nullable()->default(null);
            $table->string('dia');
            $table->string('mes');
            $table->string('ano');
            $table->string('estado');
            $table->timestamp('data_de_fecho')->nullable()->default(null);
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
        Schema::dropIfExists('sessoes_caixas');
    }
};
