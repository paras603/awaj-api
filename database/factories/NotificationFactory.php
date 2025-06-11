<?php

namespace Database\Factories;

use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receiver_id' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'sender_id' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'notification_type' => fake()->randomElement(NotificationType::all()->pluck('id')->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
