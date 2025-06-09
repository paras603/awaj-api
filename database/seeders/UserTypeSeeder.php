<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            [
                'user_type' => "admin",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_type' => "user",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
