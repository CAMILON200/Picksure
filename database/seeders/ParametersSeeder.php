<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parameters;

class ParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Parameters::count() == 0) {

            Parameters::create([
                'name_parameter'         => 'max_upload_images',
                'value_parameter'        => '5',
            ]);
            
            Parameters::create([
                'name_parameter'         => 'max_weight_image',
                'value_parameter'        => '2000',
            ]);

            Parameters::create([
                'name_parameter'         => 'max_images_per_pauta',
                'value_parameter'        => '3',
            ]);
            Parameters::create([
                'name_parameter'         => 'max_images_pautadas_per_pagination',
                'value_parameter'        => '2',
            ]);
            Parameters::create([
                'name_parameter'         => 'max_images_per_pagination',
                'value_parameter'        => '30',
            ]);
            Parameters::create([
                'name_parameter'         => 'price_per_images_pauta',
                'value_parameter'        => '10000',
            ]);
            Parameters::create([
                'name_parameter'         => 'url_drive_bulck_load',
                'value_parameter'        => 'https://docs.google.com/spreadsheets/d/1czF0fX6nXT8nUr6EOE8EtTjR7fi7mze4ROpsJ6YYqLw
                ',
            ]);
        }
    }
}
