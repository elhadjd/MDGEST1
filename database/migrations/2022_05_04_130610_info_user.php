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
        //
        Schema::create('info_user',function(Blueprint $table){
            $table->id();
            $table->integer('id_user')->nullable()->default(NULL);
            $table->string('pais')->nullable()->default(NULL);
            $table->string('cidade')->nullable()->default(NULL);
            $table->string('sede')->nullable()->default(NULL);
            $table->string('edificio')->nullable()->default(NULL);
            $table->string('telefone')->nullable()->default(NULL);
            $table->string('genero')->nullable()->default(NULL);
            $table->string('estado_civil')->nullable()->default(NULL);
            $table->date('data_naicimento')->nullable()->default(NULL);
            $table->timestamp('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
