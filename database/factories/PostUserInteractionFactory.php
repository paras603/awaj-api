<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostUserInteraction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostUserInteraction>
 */
class PostUserInteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all()->pluck('id')->toArray();
        $postIds = Post::all()->pluck('id')->toArray();

        if(empty($userIds)){
            $userIds = [User::factory()->create()->id];
        }
        if(empty($postIds)){
            $postIds = [Post::factory()->create()->id];
        }

        do{
            $userId = $this->faker->randomElement($userIds);
            $postId = $this->faker->randomElement($postIds);

            $exist = PostUserInteraction::where('user_id', $userId)
                ->where('post_id', $postId)
                ->exists();
        }while($exist);

        return [
            'post_id' => $postId,
            'user_id' => $userId,
            'voteStatus' => $this->faker->randomElement([-1,0,1]),
            'isBookmarked' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
