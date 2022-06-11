<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("sucursals")->insert([
            [
                "nombre" => "Paseo",
                "direccion" => "San Salvador",
            ],
            [
                "nombre" => "Merliot",
                "direccion" => "Santa Tecla",
            ],
            ]);
    }
}
