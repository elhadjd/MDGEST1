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
        Schema::create('pedido_fatura_models', function (Blueprint $table) {
            $table->id();
            $table->integer('IdEncomenda')->nullable()->default(null);
            $table->integer('OrdenALT')->nullable()->default(null);
            $table->integer('IdProd')->nullable()->default(null);
            $table->integer('quantidade')->nullable()->default(null);
            $table->float('PrecoCusto')->nullable()->default(null);
            $table->float('PrecoVenda')->nullable()->default(null);
            $table->float('TotalVenda')->nullable()->default(null);
            $table->float('TotalCusto')->nullable()->default(null);
            $table->float('Desconto')->nullable()->default(null);
            $table->float('TotalDesconto')->nullable()->default(null);
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
        Schema::dropIfExists('pedido_fatura_models');
    }
};
