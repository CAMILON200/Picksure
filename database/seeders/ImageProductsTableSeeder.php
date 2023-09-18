<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('imageproducts')->insert([
            [
                "img_url" => "imageproducts/post1.jpg",
                "user_id" => 1,
                "is_public" => 1,
                "status" => 1
            ],
            [
                "img_url" => "imageproducts/post2.jpg",
                "user_id" => 1,
                "is_public" => 1,
                "status" => 1
            ]
        ]);
    }
}
