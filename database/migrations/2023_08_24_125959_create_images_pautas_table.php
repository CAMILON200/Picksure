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
        Schema::create('images_pautas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imageproducts_id');
			$table->foreign('imageproducts_id')->references('id')->on('imageproducts');
            $table->unsignedBigInteger('pautasuser_id');
			$table->foreign('pautasuser_id')->references('id')->on('pautas_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_pautas');
    }
};
