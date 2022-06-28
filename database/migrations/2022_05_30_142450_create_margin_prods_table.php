<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('margin_prods', function (Blueprint $table) {
            $table->id();
            $table->integer('id_prod')->nullable()->default(null);
            $table->float('PrecoCusto')->nullable()->default(null);
            $table->float('PrecoVenda')->nullable()->default(null);
            $table->float('margin')->nullable()->default(null);
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
        Schema::dropIfExists('margin_prods');
    }
};
