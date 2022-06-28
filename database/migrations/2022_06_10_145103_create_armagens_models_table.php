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
        Schema::create('armagens_models', function (Blueprint $table) {
            $table->id();
            $table->string('NomeArmagen')->nullable()->default(null);
            $table->string('Cidade')->nullable()->default(null);
            $table->string('Bairo')->nullable()->default(null);
            $table->string('NumeroCasa')->nullable()->default(null);
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
        Schema::dropIfExists('armagens_models');
    }
};
