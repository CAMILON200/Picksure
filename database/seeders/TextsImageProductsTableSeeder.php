<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextsImageProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('texts_imageproducts')->insert([
            [
                "title" => "Imagen 1",
                "description" => "descripcion imagen 1",
                "imageproduct_id" => 1,
                "language" => "ES",
            ],
            [
                "title" => "Image 1",
                "description" => "description image 1",
                "imageproduct_id" => 1,
                "language" => "EN",
            ],
            [
                "title" => "Imagen 2",
                "description" => "descripcion imagen 2",
                "imageproduct_id" => 2,
                "language" => "ES",
            ],
            [
                "title" => "Image 2",
                "description" => "description image 2",
                "imageproduct_id" => 2,
                "language" => "EN",
            ]
        ]);
    }
}
