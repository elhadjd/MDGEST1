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
        Schema::create('pagamentos_pos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_session')->nullable()->default(null);
            $table->integer('id_encomenda')->nullable()->default(null);
            $table->float('numerario')->nullable()->default(null);
            $table->float('multicaixa')->nullable()->default(null);
            $table->float('trasferencia')->nullable()->default(null);
            $table->float('valorPago')->nullable()->default(null);
            $table->float('troco')->nullable()->default(null);
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
        Schema::dropIfExists('pagamentos_pos');
    }
};
