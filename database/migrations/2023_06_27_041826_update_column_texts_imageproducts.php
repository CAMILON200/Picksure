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
        Schema::table('texts_imageproducts', function (Blueprint $table) {
            $table->string('language');
            //$table->dropForeign('texts_imageproducts_language_id_foreign');
            //$table->dropColumn('language_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('texts_imageproducts', function (Blueprint $table) {
            //
        });
    }
};
