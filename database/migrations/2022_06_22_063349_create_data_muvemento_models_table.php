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
        Schema::create('data_muvemento_models', function (Blueprint $table) {
            $table->id();
            $table->integer('idResponsavel')->nullable()->default(null);
            $table->string('dia')->nullable()->default(null);
            $table->string('mes')->nullable()->default(null);
            $table->string('ano')->nullable()->default(null);
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
        Schema::dropIfExists('data_muvemento_models');
    }
};
