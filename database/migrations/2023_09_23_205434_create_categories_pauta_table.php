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
        Schema::create('categories_pautas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->unsignedBigInteger('pauta_id');
			$table->foreign('pauta_id')->references('id')->on('pautas_users');
			$table->unsignedInteger('category_id');
			$table->foreign('category_id')->references('id')->on('categories');
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
        Schema::table('categories_pauta', function (Blueprint $table) {
            //
        });
    }
};
