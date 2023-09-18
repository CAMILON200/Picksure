<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (Language::count() == 0) {

            Language::create([
                'name'           => 'Español Latino',
                'prefijo'        => 'ES',
            ]);

            Language::create([
                'name'           => 'Ingles',
                'prefijo'        => 'EN',
            ]);
        }
    }
}
