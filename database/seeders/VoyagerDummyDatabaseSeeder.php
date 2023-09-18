<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VoyagerDummyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            LocationsTableSeeder::class,
            LanguagesTableSeeder::class,
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            PagesTableSeeder::class,
            TranslationsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            ImageProductsTableSeeder::class,
            ImageProductsCategoryTableSeeder::class,
            TextsCategoriesTableSeeder::class,
            TextsImageProductsTableSeeder::class,
            ParametersSeeder::class,
        ]);
    }
}
