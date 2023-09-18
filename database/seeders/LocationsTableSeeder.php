<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Locations;

class LocationsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file.
	 *
	 * @return void
	 */
	public function run()
	{
		if (Locations::count() == 0) {

			Locations::insert([
				[
					'name'							=> 'Colombia',
				],
				[
					'name'							=> 'USA',
				],
				[
					'name'							=> 'España',
				],
				[
					'name'							=> 'Valle del cauca',
				],
				[
					'name'							=> 'Cali',
				]
			]);
		}
	}
}
