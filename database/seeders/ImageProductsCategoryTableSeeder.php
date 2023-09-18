<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageProductsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('imageproducts_category')->insert([
            [
                "imageproduct_id" => "1",
                "category_id" => "1",
            ],
            [
                "imageproduct_id" => "2",
                "category_id" => "2",
            ]
        ]);
    }
}
