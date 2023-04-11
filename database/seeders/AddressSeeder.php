<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = date("Y-m-d H:i:s");

        DB::table('addresses')->insert([
            'address' => 'Rua dos Tolos, 0',
            'customer_id' => 1,
            'city_id' => 3550308,
            'state_id' => 35,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
