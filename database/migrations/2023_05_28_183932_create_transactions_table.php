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
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->bigIncrements('id');
            $table->unsignedBigInteger('publicity_package_id');
			$table->foreign('publicity_package_id')->references('id')->on('publicity_packages');
            $table->unsignedBigInteger('publicity_id');
			$table->foreign('publicity_id')->references('id')->on('publicity');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('transactions');
    }
};
