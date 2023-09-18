<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('texts_categories')->insert([
            [
                "name" => "Categoria 1",
                "category_id" => 1,
                "language" => "ES",
            ],
            [
                "name" => "Category 1",
                "category_id" => 1,
                "language" => "EN",
            ],
            [
                "name" => "Categoria 2",
                "category_id" => 2,
                "language" => "ES",
            ],
            [
                "name" => "Category 2",
                "category_id" => 2,
                "language" => "EN",
            ]
        ]);
    }
}
