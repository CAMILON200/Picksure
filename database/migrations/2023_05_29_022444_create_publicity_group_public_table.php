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
        Schema::create('publicity_group_public', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->bigIncrements('id');
            $table->unsignedBigInteger('group_public_id');
			$table->foreign('group_public_id')->references('id')->on('group_public');
            $table->unsignedBigInteger('publicity_id');
			$table->foreign('publicity_id')->references('id')->on('publicity');
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
        Schema::dropIfExists('publicity_group_public');
    }
};
