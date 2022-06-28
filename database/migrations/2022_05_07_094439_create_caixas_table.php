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
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable()->default(null);
            $table->integer('id_admin')->nullable()->default(null);
            $table->string('estado')->nullable()->default(null);
            $table->string('impresao')->nullable()->default(null);
            $table->integer('id_user_relation')->nullable()->default(null);
            $table->integer('Armagen')->nullable()->default(null);
            $table->string('impresaoCliente')->nullable()->default(null);
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
        Schema::dropIfExists('caixas');
    }
};
