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
                "name" => "Baños",
                "category_id" => 1,
                "language" => "ES",
            ],
            [
                "name" => "Bathroom",
                "category_id" => 1,
                "language" => "EN",
            ],
            [
                "name" => "BBQ",
                "category_id" => 2,
                "language" => "ES",
            ],
            [
                "name" => "BBQ",
                "category_id" => 2,
                "language" => "EN",
            ],
            [
                "name" => "Cabañas",
                "category_id" => 3,
                "language" => "ES",
            ],
            [
                "name" => "Cottages",
                "category_id" => 3,
                "language" => "EN",
            ],
            [
                "name" => "Casas de playa",
                "category_id" => 4,
                "language" => "ES",
            ],
            [
                "name" => "Beach houses",
                "category_id" => 4,
                "language" => "EN",
            ],
            [
                "name" => "Casas",
                "category_id" => 5,
                "language" => "ES",
            ],
            [
                "name" => "Houses",
                "category_id" => 5,
                "language" => "EN",
            ],
            [
                "name" => "CGI",
                "category_id" => 6,
                "language" => "ES",
            ],
            [
                "name" => "CGI",
                "category_id" => 6,
                "language" => "EN",
            ],
            [
                "name" => "Chimeneas",
                "category_id" => 7,
                "language" => "ES",
            ],
            [
                "name" => "Fireplace",
                "category_id" => 7,
                "language" => "EN",
            ],
            [
                "name" => "Cocinas",
                "category_id" => 8,
                "language" => "ES",
            ],
            [
                "name" => "Kitchen",
                "category_id" => 8,
                "language" => "EN",
            ],
            [
                "name" => "Comedor",
                "category_id" => 9,
                "language" => "ES",
            ],
            [
                "name" => "Dining room",
                "category_id" => 9,
                "language" => "EN",
            ],
            [
                "name" => "Edificios",
                "category_id" => 10,
                "language" => "ES",
            ],
            [
                "name" => "Buildings",
                "category_id" => 10,
                "language" => "EN",
            ],
            [
                "name" => "Electodomésticos",
                "category_id" => 11,
                "language" => "ES",
            ],
            [
                "name" => "Appliances",
                "category_id" => 11,
                "language" => "EN",
            ],
            [
                "name" => "Escaleras",
                "category_id" => 12,
                "language" => "ES",
            ],
            [
                "name" => "Stairs",
                "category_id" => 12,
                "language" => "EN",
            ],
            [
                "name" => "Grifería",
                "category_id" => 13,
                "language" => "ES",
            ],
            [
                "name" => "Faucets",
                "category_id" => 13,
                "language" => "EN",
            ],
            [
                "name" => "GYM",
                "category_id" => 14,
                "language" => "ES",
            ],
            [
                "name" => "GYM",
                "category_id" => 14,
                "language" => "EN",
            ],
            [
                "name" => "Habitacion",
                "category_id" => 15,
                "language" => "ES",
            ],
            [
                "name" => "Bedroom",
                "category_id" => 15,
                "language" => "EN",
            ],
            [
                "name" => "Habitacion de Niños",
                "category_id" => 16,
                "language" => "ES",
            ],
            [
                "name" => "Kids room",
                "category_id" => 16,
                "language" => "EN",
            ],
            [
                "name" => "Hotel",
                "category_id" => 17,
                "language" => "ES",
            ],
            [
                "name" => "Hotels",
                "category_id" => 17,
                "language" => "EN",
            ],
            [
                "name" => "Iluminación",
                "category_id" => 18,
                "language" => "ES",
            ],
            [
                "name" => "Lighting",
                "category_id" => 18,
                "language" => "EN",
            ],
            [
                "name" => "Interiorismo",
                "category_id" => 19,
                "language" => "ES",
            ],
            [
                "name" => "Interior design",
                "category_id" => 19,
                "language" => "EN",
            ],
            [
                "name" => "Lavanderia",
                "category_id" => 20,
                "language" => "ES",
            ],
            [
                "name" => "Laundry room",
                "category_id" => 20,
                "language" => "EN",
            ],
            [
                "name" => "Materiales",
                "category_id" => 21,
                "language" => "ES",
            ],
            [
                "name" => "Materials",
                "category_id" => 21,
                "language" => "EN",
            ],
            [
                "name" => "Muebles exterior",
                "category_id" => 22,
                "language" => "ES",
            ],
            [
                "name" => "Outdoor Furniture",
                "category_id" => 22,
                "language" => "EN",
            ],
            [
                "name" => "Muebles",
                "category_id" => 23,
                "language" => "ES",
            ],
            [
                "name" => "Furniture",
                "category_id" => 23,
                "language" => "EN",
            ],
            [
                "name" => "Piscinas",
                "category_id" => 24,
                "language" => "ES",
            ],
            [
                "name" => "Pools",
                "category_id" => 24,
                "language" => "EN",
            ],
            [
                "name" => "Playromm",
                "category_id" => 25,
                "language" => "ES",
            ],
            [
                "name" => "Gameroom",
                "category_id" => 25,
                "language" => "EN",
            ],
            [
                "name" => "Restaurantes",
                "category_id" => 26,
                "language" => "ES",
            ],
            [
                "name" => "Restaurants",
                "category_id" => 26,
                "language" => "EN",
            ],
            [
                "name" => "Sala",
                "category_id" => 27,
                "language" => "ES",
            ],
            [
                "name" => "Livingroom",
                "category_id" => 27,
                "language" => "EN",
            ],
            [
                "name" => "Teatro en casa",
                "category_id" => 28,
                "language" => "ES",
            ],
            [
                "name" => "Hometheater",
                "category_id" => 28,
                "language" => "EN",
            ],
            [
                "name" => "Vestier",
                "category_id" => 29,
                "language" => "ES",
            ],
            [
                "name" => "Dressingroom",
                "category_id" => 29,
                "language" => "EN",
            ],
        ]);
    }
}
