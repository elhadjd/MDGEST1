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
        Schema::create('apps',function(Blueprint $table){
            $table->id();
            $table->string('app_name')->nullable()->default(null);
            $table->integer('id_responsavel')->nullable()->default(null);
            $table->string('estado')->nullable()->default(null);
            $table->string('empresa')->nullable()->default(null);
            $table->timestamp('data')->nullable()->default(null);
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
