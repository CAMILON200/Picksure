<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;
use App\Models\Locations;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role_sa = Role::where('name', 'superadmin')->firstOrFail();
            $locations = Locations::where('name', 'Colombia')->firstOrFail();

            User::create([
                'name'           => 'Super Admin',
                'email'          => 'superadmin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'role_id'        => $role_sa->id,
                'last_name'      => 'Picksure',
                'date_of_birth'  => '2023-05-29',
                'phone'          => '213123',
                'location'       => 'CO',
            ]);

            $role = Role::where('name', 'admin')->firstOrFail();
            $locations = Locations::where('name', 'Colombia')->firstOrFail();

            User::create([
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
                'last_name'      => 'picksure',
                'date_of_birth'  => '2023-05-29',
                'phone'          => '213123',
                'location'       => 'CO',
            ]);
        }
    }
}
