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
					'code_iso'						=> 'CO'
				],
				[
					'name'							=> 'USA',
					'code_iso'						=> 'US'
				],
				[
					'name'							=> 'España',
					'code_iso'						=> 'ES'
				],
				[
					'name'							=> 'Mexico',
					'code_iso'						=> 'MX'
				],
				[
					'name'							=> 'Francia',
					'code_iso'						=> 'FR'
				]
			]);
		}
	}
}
