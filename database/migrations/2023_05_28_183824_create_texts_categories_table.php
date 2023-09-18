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
		Schema::create('texts_categories', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			/*$table->increments('id');*/
			$table->string('name');
			$table->unsignedInteger('category_id');
			$table->foreign('category_id')->references('id')->on('categories');
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
		Schema::dropIfExists('texts_categories');
	}
};
