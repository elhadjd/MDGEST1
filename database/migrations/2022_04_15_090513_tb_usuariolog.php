<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PharIo\Manifest\Email;

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
        Schema::create('tb_usuariolog',function(Blueprint $table){
            $table->id();
            $table->string('apelido')->nullable()->default(NULL);
            $table->integer('id_empresa')->nullable()->default(NULL);
            $table->integer('id_responsavel')->nullable()->default(NULL);
            $table->string('nome_completo')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('imagem')->nullable()->default(NULL);
            $table->string('nivel')->nullable()->default(NULL);
            $table->string('senha')->nullable()->default(NULL);
            $table->string('estado')->nullable()->default(NULL);
            $table->timestamp('data')->nullable()->default(NULL);
            $table->rememberToken();
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
        //
        Schema::dropIfExists('users');
    }
};
