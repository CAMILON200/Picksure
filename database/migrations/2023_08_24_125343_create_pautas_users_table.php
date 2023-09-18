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
        Schema::create('pautas_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('valor');
            $table->string('description');
            $table->string('destination_url');
            $table->string('img_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pautas_users');
    }
};
