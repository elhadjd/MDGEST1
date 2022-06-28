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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('assunto')->nullable()->default(null);
            $table->float('valor')->nullable()->default(null);
            $table->integer('idUser')->nullable()->default(null);
            $table->string('dia')->nullable()->default(null);
            $table->string('mes')->nullable()->default(null);
            $table->string('ano')->nullable()->default(null);
            $table->string('dataPesquisa')->nullable()->default(null);
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
        Schema::dropIfExists('gastos');
    }
};
