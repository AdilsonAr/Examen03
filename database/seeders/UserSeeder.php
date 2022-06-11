<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "name" => "Jose",
                "email" => "Jose@itca.edu",
                "password" => Hash::make('admin1'),
            ],
            [
                "name" => "David",
                "email" => "David@itca.edu",
                "password" => Hash::make('admin2'),
            ],
            ]);
    }
}
