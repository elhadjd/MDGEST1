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
        Schema::create('bate_papos_models', function (Blueprint $table) {
            $table->id();
            $table->integer('IdUserPrincipal')->nullable()->default(null);
            $table->integer('IdUserDestino')->nullable()->default(null);
            $table->text('menssagen')->nullable()->default(null);
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
        Schema::dropIfExists('bate_papos_models');
    }
};
