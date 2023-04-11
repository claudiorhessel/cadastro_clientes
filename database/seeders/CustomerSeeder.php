<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = date("Y-m-d H:i:s");

        DB::table('customers')->insert([
            'full_name' => 'Cláudio Rocumback Hessel',
            'cpf' => '01234567890',
            'birtdate' => '1984-08-08',
            'gender' => 'M',
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
