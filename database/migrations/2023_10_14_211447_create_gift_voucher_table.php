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
        Schema::create('gift_voucher', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->string('code', 8);
			$table->string('type_gift');
            $table->integer('amount');
            $table->integer('state')->default(1);
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
        Schema::table('gift_voucher', function (Blueprint $table) {
            //
        });
    }
};
