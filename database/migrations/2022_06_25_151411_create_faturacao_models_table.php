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
        Schema::create('faturacao_models', function (Blueprint $table) {
            $table->id();
            $table->integer('IdUser')->nullable()->default(null);
            $table->integer('IdCliente')->nullable()->default(null);
            $table->integer('OrdenALT')->nullable()->default(null);
            $table->integer('TotalFatura')->nullable()->default(null);
            $table->timestamp('DataEncomenda')->nullable()->default(null);
            $table->timestamp('DataVencimento')->nullable()->default(null);
            $table->float('TipoFatura')->nullable()->default(null);
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
        Schema::dropIfExists('faturacao_models');
    }
};
