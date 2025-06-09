<?php

namespace Database\Seeders;

use App\Models\ActivityFeed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityFeed::factory()->count(10)->create();
    }
}
