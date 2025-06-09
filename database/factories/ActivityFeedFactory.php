<?php

namespace Database\Factories;

use App\Models\ActivityType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityFeed>
 */
class ActivityFeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'activity_type_id' => fake()->randomElement(ActivityType::all()->pluck('id')->toArray()),
            'post_id' => fake()->randomElement(Post::all()->pluck('id')->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
