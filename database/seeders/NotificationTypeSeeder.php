<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notification_types')->insert([
           [
               'type' => 'following',
               'created_at' => now(),
               'updated_at' => now(),
           ],
            [
                'type' => 'upvote',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'downvote',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'comment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'reply',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
