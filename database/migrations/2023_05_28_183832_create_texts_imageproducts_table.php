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
        Schema::create('texts_imageproducts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			/*$table->increments('id');*/
			$table->string('title');
            $table->string('description');
			$table->unsignedBigInteger('imageproduct_id');
			$table->foreign('imageproduct_id')->references('id')->on('imageproducts');
			//$table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('texts_imageproducts');
    }
};
