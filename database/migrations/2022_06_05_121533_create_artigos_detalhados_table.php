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
        Schema::create('artigos_detalhados', function (Blueprint $table) {
            $table->id();
            $table->integer('idArtigoPrincipal')->nullable()->default(null);
            $table->integer('idArtigodetalhado')->nullable()->default(null);
            $table->integer('IdResponsavel')->nullable()->default(null);
            $table->integer('Quantidade')->nullable()->default(null);
            $table->integer('QuantidadeTemporaria')->nullable()->default(null);
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
        Schema::dropIfExists('artigos_detalhados');
    }
};
