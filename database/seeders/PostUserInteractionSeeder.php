<?php

namespace Database\Seeders;

use App\Models\PostUserInteraction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostUserInteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostUserInteraction::factory()->count(50)->create();
    }
}
