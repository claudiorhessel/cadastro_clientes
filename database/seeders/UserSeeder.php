<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = date("Y-m-d H:i:s");

        DB::table('users')->insert([
            'name' => 'Cláudio Rocumback Hessel',
            'email' => 'claudiorhessel@gmail.com',
            'password' => Hash::make('claudio@123'),
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
