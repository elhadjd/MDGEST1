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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->integer('Responsavel')->nullable()->default(null);
            $table->integer('ArtigoPrencipal')->nullable()->default(null);
            $table->integer('quantidade')->nullable()->default(null);
            $table->integer('ArmagenPrencipal')->nullable()->default(null);
            $table->integer('ArmagenDestino')->nullable()->default(null);
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
        Schema::dropIfExists('transferencias');
    }
};
